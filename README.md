# JSON Api Generator
Elinizdeki json dosyalarını apiye çeviren, json dosyaları içinde istediğiniz keylere göre arama yapmanızı sağlayan php sınıfıdır.

# Kullanım
Öncelikle projeyi klonlayın.

    git clone github.com/furkandura/json_api_generator
    
Sonrasında şu kodla projeyi ayağa kaldırın. 

    php -S localhost:8889 index.php
Bundan sonrası ise projede bulunan jsons klasörüne apiye çevirmek istediğiniz json dosyalarını taşıyın. Şu şekilde kullanmaya başlayın.

Hepsini listeleme :

    http://localhost:8889/{json dosyanızın ismi}
    Örnek; /users
İdye göre veya custom field ile veri getirme :

    http://localhost:8889/{json dosyanızın ismi}/{aramak istediğiniz key}/{aradığınız value}
    Örnek; /users/id/3
		   /users/favorite_color/blue
