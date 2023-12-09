<p align="center">
    <a href="https://laravel.com" target="_blank">
        <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="200" alt="Laravel Logo">
        <img src="https://www.oduyo.com.tr/wp-content/uploads/2023/07/Oduyo_Logo-02.png" width="170" alt="Laravel Logo">
    </a>
</p>

## About Project

This project is built using Laravel 10 and incorporates the Breeze authentication scaffold with Blade templates. It's designed to manage and monitor background job processing, providing insights into job statuses and system health.

## Modifications:

- resources/views/sDashboard: Custom dashboard view for managing jobs.
- routes/web.php: Routes for job management and user registration.
- Http/Controllers/Auth/RegisteredUserController: Controller for handling new user registration.
- App/Providers/EventServiceProvider: Event service provider to register event listeners.

## New Additions:

- App/Listeners/LogSuccessfulJob: A listener that logs successful job processing in the database.
- App/Mail/SendWelcomeEmail: A mailable class for sending welcome emails to new users.
- App/Http/Controllers/DashboardController: Controller for dashboard functionalities including job management and user interactions.

## How to Run:

- Clone the repository to your local machine.
- Run composer install to install dependencies.
- Set up your environment file .env and configure your database.
- Run php artisan migrate to set up the database tables.
- Start the server using php artisan serve.

---
## Proje Hakkında
Bu proje, Laravel 10 kullanılarak oluşturulmuş ve Breeze kimlik doğrulama iskeleti Blade şablonları ile entegre edilmiştir. Arka plan işleme işlerini yönetmeye ve izlemeye yönelik tasarlanmış olup, iş durumları ve sistem sağlığı hakkında bilgiler sunar.

## Düzenlemeler:

- resources/views/sDashboard: İşleri yönetmek için özel dashboard görünümü.
- routes/web.php: İş yönetimi ve kullanıcı kaydı için rotalar.
- Http/Controllers/Auth/RegisteredUserController: Yeni kullanıcı kaydını işleyen kontrolcü.
- App/Providers/EventServiceProvider: Olay dinleyicilerini kaydetmek için olay servis sağlayıcısı.

## Yeni Eklenenler:

- App/Listeners/LogSuccessfulJob: Başarılı işleme işlerini veritabanında kaydeden bir dinleyici.
- App/Mail/SendWelcomeEmail: Yeni kullanıcılara hoş geldiniz e-postaları göndermek için bir e-posta sınıfı.
- App/Http/Controllers/DashboardController: İş yönetimi ve kullanıcı etkileşimlerini içeren dashboard işlevleri için kontrolcü.

## Nasıl Çalıştırılır:

- Repoyu yerel makinenize klonlayın.br
- Bağımlılıkları yüklemek için composer install komutunu çalıştırın.
- .env ortam dosyanızı ayarlayın ve veritabanınızı yapılandırın.
- Veritabanı tablolarını kurmak için php artisan migrate komutunu çalıştırın.
- Sunucuyu php artisan serve kullanarak başlatın.
