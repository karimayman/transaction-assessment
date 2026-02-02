<?php

namespace App\Actions;

use DOMDocument;

class createClientXml
{
    /**
     * Create a new class instance.
     */
    public function __invoke($data)
    {
        $reference = $data->reference;
        $amount = $data->amount;
        $date = $data->date;
        $notes = $data->notes;
        $currency = $data->currency;
        $sender = $data->senderAccount;
        $receiver = $data->receiverAccount;
        $paymentType = $data->paymentType;
        $chargeDetails = $data->chargeDetails;

        $doc = new DOMDocument('1.0', 'UTF-8');
        $doc->formatOutput = true;
        $paymentRequestMessage = $doc->createElement('PaymentRequestMessage');
        $doc->appendChild($paymentRequestMessage);
        $TransferInfo = $doc->createElement('TransferInfo');
        $TransferInfo->appendChild($doc->createElement('Reference', $reference));
        $TransferInfo->appendChild($doc->createElement('Date', $date));

        $amountTag = $doc->createElement('Amount', $amount);
        $TransferInfo->appendChild($doc->createElement('Currency', $currency));
        $TransferInfo->appendChild($amountTag);
        $paymentRequestMessage->appendChild($TransferInfo);

        $senderTag = $doc->createElement('Sender');
        $senderTag->appendChild($doc->createElement('AccountNumber', $sender));
        $paymentRequestMessage->appendChild($senderTag);

        $receiverTag = $doc->createElement('Receiver');
        $receiverTag->appendChild($doc->createElement('AccountNumber', $receiver));
        $paymentRequestMessage->appendChild($receiverTag);
        $doc->preserveWhiteSpace = false;
        if(count($notes) > 0){
            $notesTag = $doc->createElement('Notes');
            foreach ($notes as $note){
                $notesTag->appendChild($doc->createElement('Note', $note));
            }
            $paymentRequestMessage->appendChild($notesTag);
        }
        if ((int) $paymentType !== 99) {
            $paymentRequestMessage->appendChild($doc->createElement('PaymentType', (string) $paymentType));
        }
        if ((string) $chargeDetails !== 'SHA') {
            $paymentRequestMessage->appendChild($doc->createElement('ChargeDetails', (string) $chargeDetails));
        }
        return $doc->saveXML();

    }
}
