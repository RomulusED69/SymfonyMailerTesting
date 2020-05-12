<?php

declare(strict_types=1);

namespace Yproximite\SymfonyMailerTesting\Normalizer;

use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\DataPart;

/**
 * The return data type should be synchronized with the TypeScript type `SymfonyMailerTesting.Email`.
 *
 * @see src/Bridge/JavaScript/index.d.ts
 */
class EmailNormalizer
{
    /**
     * @return array<string, mixed>
     */
    public function normalize(Email $email): array
    {
        return [
            'headers'     => $email->getHeaders()->toArray(),
            'from'        => array_map(function (Address $address): string { return $address->toString(); }, $email->getFrom()),
            'to'          => array_map(function (Address $address): string { return $address->toString(); }, $email->getTo()),
            'cc'          => array_map(function (Address $address): string { return $address->toString(); }, $email->getCc()),
            'bcc'         => array_map(function (Address $address): string { return $address->toString(); }, $email->getBcc()),
            'subject'     => $email->getSubject(),
            'text'        => [
                'body'    => $email->getTextBody(),
                'charset' => $email->getTextCharset(),
            ],
            'html'        => [
                'body'    => $email->getHtmlBody(),
                'charset' => $email->getHtmlCharset(),
            ],
            'attachments' => array_map(function (DataPart $dataPart): string {
                return $dataPart->asDebugString();
            }, $email->getAttachments()),
        ];
    }
}
