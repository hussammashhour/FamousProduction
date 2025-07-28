<?php

namespace App\Filament\Resources\SupportTicketReplyResource\Pages;

use App\Filament\Resources\SupportTicketReplyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSupportTicketReplies extends ListRecords
{
    protected static string $resource = SupportTicketReplyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
