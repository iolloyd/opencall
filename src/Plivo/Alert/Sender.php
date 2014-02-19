<?php

namespace Plivo\Alert;

use Plivo\Log\Entry as LogEntry;

class Sender
{
    protected $repo;

    public function __construct(Repository $repo)
    {
        $this->repo = $repo;
    }

    public function send(LogEntry $log)
    {
        error_log('checking alert');
        // check if failed
        if (!$log->isFailed())
            return false;

        // get client alert info
        $alert = $this->repo->find($log->getClientID());
        if ($alert == null)
            return false;

        // check if alert is triggered
        if (!$alert->isTriggered($log))
            return false;

        // send email
        return $this->email($alert, $log);
    }

    protected function filterText($alert, $log, $text)
    {
        $date_start = $log->getDateStart()->format('H:i') . '(GMT+8) on ' . $log->getDateStart()->format('l jS \o\f F');

        $ftext = str_replace('[date_in]', $date_start, $text);
        $ftext = str_replace('[origin_number]', $log->getOriginFormatted(), $ftext);
        $ftext = str_replace('[dialled_number]', $log->getDialledFormatted(), $ftext);
        $ftext = str_replace('[reason]', $log->getBHangupCause(), $ftext);
        $ftext = str_replace('[lead_rescue_url]', 'http://dev.calltracking.hk/client/' . $log->getClientID() . '/lead_rescue', $ftext);

        return $ftext;
    }

    protected function email(Entry $alert, LogEntry $log)
    {
        error_log('sending email - ' . $alert->getEmail());
        $subject = $this->filterText($alert, $log, 'Missed Call Alert: [origin_number] called your ad: [advert] in [campaign].');

        $m_template = file_get_contents(__DIR__ . '/../../../email/alert.txt');
        $message = $this->filterText($alert, $log, $m_template);
        $headers = "From: noreply@calltracking.hk\r\n" .
            "Reply-To: noreply@calltracking.hk\r\n" .
            "X-Mailer: PHP/" . phpversion();

        mail($alert->getEmail(), $subject, $message, $headers);
    }
}