<?php

namespace App\Filament\Resources\SupportTicketReplyResource\Pages;

use App\Filament\Resources\SupportTicketReplyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSupportTicketReply extends EditRecord
{
    protected static string $resource = SupportTicketReplyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
