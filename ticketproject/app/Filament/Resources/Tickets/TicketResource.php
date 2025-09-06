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
use Filament\Tables\Columns\TextColumn;

use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\HtmlString;
use App\Models\Post;
use Filament\Actions\Action;

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
                    'critical' => 'Critical',
                    'high' => 'High',
                    'medium' => 'Medium',
                    'low' => 'Low',
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
                ->label('Impact')
                ->placeholder('Select a impact')
                ->options([
                    'high' => 'High',
                    'medium' => 'Medium',
                    'low' => 'Low',
                ]),
            Select::make('source')
                ->label('Source')
                ->placeholder('Select a source')
                ->options([
                    'web' => 'Web',
                    'email' => 'E-Mail',
                    'phone' => 'Phone',
                    'chat' => 'Chat',
                ]),
            FileUpload::make('attachments')
            ->label('Attachments')
            ->directory('tickets-attachments') 
            ->disk('public')
            ->visibility('public')
            ->multiple() 
            ->enableDownload() 
            ->enableOpen() 
            ->storeFileNamesIn('attachment_file_names')
            ->reorderable(),
            Select::make('status')
            ->label('Status')
            ->placeholder('Select a status')
            ->options([
                'open' => 'Open',
                'in_progress' => 'In Progress',
                'on_hold' => 'On Hold',
                'resolved' => 'Resolved',
                'closed' => 'Closed',
            ])
            ->visible(fn () => auth()->user()->hasRole('agent'))
            ->default('Open'),

             
            
    ]);
    }

    public static function table(Table $table): Table
    {
        return TicketsTable::configure($table)
        ->columns([
            TextColumn::make('title')->label('Title'),
            TextColumn::make('description')->label('Description'),
            TextColumn::make('status')
            ->label('Status')
            ->formatStateUsing(function ($state) {
                return match($state) {
                    'open' => 'Open',
                    'in_progress' => 'In Progress',
                    'on_hold' => 'On Hold',
                    'resolved' => 'Resolved',
                    'closed' => 'Closed',
                    default => $state,
                };
            }),
            TextColumn::make('priority')
            ->label('Priority')
            ->formatStateUsing(function ($state) {
                return match($state) {
                    'low' => 'Low',
                    'medium' => 'Medium',
                    'high' => 'High',
                    'critical' => 'Critical',
                    default => $state,
                };
            }),
            TextColumn::make('category')->label('Category'),
            TextColumn::make('impact')
            ->label('Impact')
            ->formatStateUsing(function ($state) {
                return match($state) {
                    'low' => 'Low',
                    'medium' => 'Medium',
                    'high' => 'High',
                    default => $state,
                };
            }),
            TextColumn::make('source')
            ->label('Source')
            ->formatStateUsing(function ($state) {
                return match($state) {
                    'web' => 'Web',
                    'email' => 'E-Mail',
                    'phone' => 'Phone',
                    'chat' => 'Chat',
                    default => $state,
                };
            }),
            TextColumn::make('assignedUser.name')->label('Assigned User'),
            TextColumn::make('createdBy.name')->label('Created by User'),
            TextColumn::make('sla_due_date')->label('SLA Due Date'),
            


            TextColumn::make('attachments')
            ->label('Attachments')
            ->formatStateUsing(function ($state) {
                if (empty($state)) {
                    return 'No files';
                }

                if (is_string($state)) {
                    $files = explode(',', $state);
                    $files = array_filter(array_map('trim', $files));
                }

                $links = [];
                foreach ($files as $file) {
                    // Türkçe ve boşluk karakterlerini encode et
                    $url = asset('storage/' . implode('/', array_map('rawurlencode', explode('/', $file))));
                    $filename = basename($file);

                    $links[] = '<a href="' . $url . '" target="_blank" download>Download File</a>';
                }

                return new HtmlString(implode('<br>', $links));
            })
            ->html(),

            TextColumn::make('resolved_at')->label('Resolved Date'),
            TextColumn::make('created_at')->label('Created Time'),
            TextColumn::make('updated_at')->label('Updated Time'),

        ])
        ->filters([
            
        ]);
    }

    public static function getEloquentQuery(): Builder
{
    $user = auth()->user();

    if ($user->hasRole('admin') || $user->hasRole('agent')) {
        return parent::getEloquentQuery(); // tüm ticketlar
    }

    // normal user sadece kendi ticketlarını görsün
    return parent::getEloquentQuery()->where('created_by_user_id', $user->id);
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
