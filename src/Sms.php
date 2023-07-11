<?php

namespace PHPMaker2023\pembuatan_mesin;

/**
 * SMS class
 */
abstract class Sms
{
    public $Recipient = ""; // Recipient
    public $Content = ""; // Content
    public $SendErrDescription; // Send error description

    /**
     * Load message from template
     *
     * @param string $fn File name
     * @param string $langId Language ID
     * @return void
     */
    public function load($fn, $langId = "")
    {
        global $CurrentLanguage;
        $langId = ($langId == "") ? $CurrentLanguage : $langId;
        $pos = strrpos($fn, '.');
        if ($pos !== false) {
            $wrkname = substr($fn, 0, $pos); // Get file name
            $wrkext = substr($fn, $pos + 1); // Get file extension
            $wrkpath = PathCombine(AppRoot(true), Config("SMS_TEMPLATE_PATH"), true); // Get file path
            $ar = ($langId != "") ? ["_" . $langId, "-" . $langId, ""] : [""];
            $exist = false;
            foreach ($ar as $suffix) {
                $wrkfile = $wrkpath . $wrkname . $suffix . "." . $wrkext;
                $exist = file_exists($wrkfile);
                if ($exist) {
                    break;
                }
            }
            if (!$exist) {
                return;
            }
            $wrk = file_get_contents($wrkfile); // Load template file content
            if (StartsString("\xEF\xBB\xBF", $wrk)) { // UTF-8 BOM
                $wrk = substr($wrk, 3);
            }
            $this->Content = trim($wrk);
        }
    }

    /**
     * Replace content
     *
     * @param string $find String to find
     * @param string $replaceWith String to replace
     * @return void
     */
    public function replaceContent($find, $replaceWith)
    {
        $this->Content = str_replace($find, $replaceWith, $this->Content);
    }

    /**
     * Send SMS
     *
     * @return bool Whether SMS is sent successfully
     */
    public function send()
    {
        //var_dump($this->Content, $this->Recipient);
        return false; // Not implemented
    }
}
