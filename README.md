Note: Để dự án chạy thành công thì yêu cầu PHP và xampp của bạn phải có từ version 7.^
### Cách cài đặt dự án laravel clone từ github
# Bước 1: Mở Terminal và thực hiện clone dự án và vào thư mục dự án bằng câu lệnh sau:
- git clone https://github.com/RuLe1/shoppingcart_laravel.git
- cd shoppingcart_laravel
# Bước 2: Chạy composer và npm để cài đặt các gói cần thiết trong dự án
- composer install
- npm install 
# Bước 3: Tạo database và config database
Copy file .env.example ra file mới đặt tên là .env
Cập nhật file env của bạn như sau:

DB_CONNECTION=mysql          
DB_HOST=127.0.0.1            
DB_PORT=3306                 
DB_DATABASE=shoppingcart     
DB_USERNAME=root             
DB_PASSWORD= 
- Upload file database shoppingcart.sql có trong dự án lên phpmyadmin
# Bước 4: Tạo ra key cho dự án
php artisan key:generate
# Bước 5: Xây dựng các styles và scripts(dùng cmd)
npm run
# Bước 6: Chạy Phpunit
Sau khi dự án được cài đặt,hãy chạy phpunit. để đảm bảo tất cả các chức năng đang hoạt động chính xác.
Từ gốc của dự án của bạn chạy:
phpunit
