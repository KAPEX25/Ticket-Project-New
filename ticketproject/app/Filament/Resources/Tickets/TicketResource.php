<?php

namespace App\Filament\Resources\Tickets;

use App\Filament\Resources\Tickets\Pages\CreateTicket;
use App\Filament\Resources\Tickets\Pages\EditTicket;
use App\Filament\Resources\Tickets\Pages\ListTickets;
use App\Filament\Resources\Tickets\Schemas\TicketForm;
use App\Filament\Resources\Tickets\Tables\TicketsTable;
use App\Models\Ticket;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Tickets';

    public static function form(Schema $schema): Schema
    {
        return TicketForm::configure($schema)
        ->schema([
            TextInput::make('title')
                ->label('Title')
                ->required()
                ->maxLength(25)
                ->minLength(3),
            Select::make('priority')
                ->label('Priority')
                ->placeholder('Select a priority')
                ->required()
                ->options([
                    'Critical' => 'Critical',
                    'High' => 'High',
                    'Medium' => 'Medium',
                    'Low' => 'Low',
                ]),
            Textarea::make('description')
                ->label('Description')
                ->rows(2)
                ->minLength(10)
                ->required(),
            Select::make('category')
                ->label('Category')
                ->placeholder('Select a category')
                ->required()
                ->options([
                'Hardware Issues' => [
                    'Computer (Laptop / Desktop)' => 'Computer (Laptop / Desktop)',
                    'Printer / Scanner' => 'Printer / Scanner',
                    'Keyboard / Mouse' => 'Keyboard / Mouse',
                    'Monitor' => 'Monitor',
                    'Phone / Tablet' => 'Phone / Tablet',
                    'Network Devices (Modem, Switch, Router)' => 'Network Devices (Modem, Switch, Router)',
                ],
                'Software Issues' => [
                    'Operating System (Windows, Linux, macOS)' => 'Operating System (Windows, Linux, macOS)',
                    'Office Applications (Word, Excel, PowerPoint)' => 'Office Applications (Word, Excel, PowerPoint)',
                    'ERP / CRM Systems' => 'ERP / CRM Systems',
                    'Web Applications' => 'Web Applications',
                    'Update / Licensing Problems' => 'Update / Licensing Problems',
                ],
                'Network and Connectivity' => [
                    'Internet Outage' => 'Internet Outage',
                    'VPN Issues' => 'VPN Issues',
                    'Wi-Fi Connection' => 'Wi-Fi Connection',
                    'LAN / IP Conflict' => 'LAN / IP Conflict',
                    'DNS Problems' => 'DNS Problems',
                ],
                'User Accounts' => [
                    'Password Reset' => 'Password Reset',
                    'New Account Creation' => 'New Account Creation',
                    'Add / Remove Permissions' => 'Add / Remove Permissions',
                    'Access Issues' => 'Access Issues',
                ],
                'Email & Communication' => [
                    'Email Sending / Receiving Problems' => 'Email Sending / Receiving Problems',
                    'Spam / Junk Issues' => 'Spam / Junk Issues',
                    'Mail Client Settings (Outlook, Thunderbird)' => 'Mail Client Settings (Outlook, Thunderbird)',
                    'Group Mail Configuration' => 'Group Mail Configuration',
                ],
                'Security' => [
                    'Virus / Malware' => 'Virus / Malware',
                    'Phishing / Fake Email' => 'Phishing / Fake Email',
                    'Unauthorized Access' => 'Unauthorized Access',
                    'Firewall Settings' => 'Firewall Settings',
                ],
                'Support & Consulting' => [
                    'User Training' => 'User Training',
                    'New Feature Request' => 'New Feature Request',
                    'Project Support' => 'Project Support',
                    'Information Request' => 'Information Request',
                ],
                'Hardware / Software Requests' => [
                    'New Device Request' => 'New Device Request',
                    'License Request' => 'License Request',
                    'Hardware Upgrade' => 'Hardware Upgrade',
                    'Software Installation' => 'Software Installation',
                ],
                'Data & Backup' => [
                    'Data Loss' => 'Data Loss',
                    'Restore from Backup' => 'Restore from Backup',
                    'Backup Errors' => 'Backup Errors',
                    'Disk / Storage Issues' => 'Disk / Storage Issues',
                ],
                'Performance Issues' => [
                    'Slow Computer' => 'Slow Computer',
                    'Slow Application' => 'Slow Application',
                    'Network Performance' => 'Network Performance',
                    'High Server Resource Usage' => 'High Server Resource Usage',
                ],
                'Other' => [
                    'Unspecified Issue' => 'Unspecified Issue',
                    'Custom User Request' => 'Custom User Request',
                    'General Inquiry' => 'General Inquiry',
                ],
            ]),
            Select::make('impact')
                ->label('İmpact')
                ->placeholder('Select a impact')
                ->options([
                    'High' => 'High',
                    'Medium' => 'Medium',
                    'Low' => 'Low',
                ]),
            Select::make('source')
                ->label('Source')
                ->placeholder('Select a source')
                ->options([
                    'Web' => 'Web',
                    'E-Mail' => 'E-Mail',
                    'Phone' => 'Phone',
                    'Chat' => 'Chat',
                ]),
            FileUpload::make('attachments')
            ->label('Attachments')
            ->directory('tickets-attachments') 
            ->visibility('public')
            ->multiple() 
            ->enableDownload() 
            ->enableOpen() 
            ->preserveFilenames() 
            ->reorderable(), 
            
    ]);
    }

    public static function table(Table $table): Table
    {
        return TicketsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTickets::route('/'),
            'create' => CreateTicket::route('/create'),
            'edit' => EditTicket::route('/{record}/edit'),
        ];
    }
}
