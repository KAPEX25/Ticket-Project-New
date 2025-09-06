# ITSM Mini Modül

Laravel 11 + Filament + Spatie Roles & Permissions + Sanctum tabanlı ITSM (Ticket Management) mini modül.

---

## Kurulum

1. Projeyi klonla:
    ```bash
    git clone https://github.com/USERNAME/Ticket-Project.git
    cd Ticket-Project
2. Paketleri yükle:
    ```bash 
    composer install
    npm install && npm run build
3. .env dosyasını ayarla:
    ```bash
    DB_DATABASE=ticketproject
    DB_USERNAME=root
    DB_PASSWORD=
4. Migration & seed çalıştır:
    ```bash
    php artisan migrate --seed
5. Uygulama anahtarını oluştur:
    ```bash
    php artisan key:generate
6. Storage link oluştur:
    ```bash
    php artisan storage:link
7. Server başlat:
    ```bash
    php artisan serve

## Kullanıcı Rolleri
 ---------------------------------------------------
| Rol   | Yetkiler                                  |
| ----- | ----------------------------------------- |
| Admin | Tüm yönetim (Users, Tickets)              |
| Agent | Tüm ticketları görür, çözüm atar          |
| User  | Sadece kendi ticketlarını görür/oluşturur |
 ---------------------------------------------------
## Test kullanıcıları (Seeder ile otomatik eklenir)
 ------------------------------------------------------------------
| Rol   | Email                                         | Password |
| ----- | --------------------------------------------- | -------- |
| Admin | [admin@example.com](mailto:admin@example.com) | password |
| Agent | [agent@example.com](mailto:agent@example.com) | password |
| User  | [user@example.com](mailto:user@example.com)   | password |
 ------------------------------------------------------------------
## Tickets Özellikleri

- Alanlar: Title, Description, Priority, Category, Impact, Source, Attachments
- Status yönetimi: open → resolved
- Agent ticket çözümlediğinde: resolved_at ve assigned_user_id güncellenir
- User: sadece kendi ticketlarını görebilir
- Agent & Admin: tüm ticketlara erişebilir

## API Kullanımı

1. Login
    ```bash
        POST /api/login
        Content-Type: application/json

        {
        "email": "agent@example.com",
        "password": "password"
        }
    response: token
2. Ticket Listesi
    ```bash
    GET /api/tickets
    Authorization: Bearer {token}
3. Ticket Oluştur
    ```bash
    POST /api/tickets
    Authorization: Bearer {token}
    Content-Type: application/json

    {
    "title": "Printer not working",
    "description": "The printer is jammed.",
    "priority": "High",
    "category": "Printer / Scanner",
    "impact": "Medium",
    "source": "Web"
    }
4. Ticket Çözümleme
    ```bash
    POST /api/tickets/1/resolve
    Authorization: Bearer {token}
