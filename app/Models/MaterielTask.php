<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterielTask extends Model
{
    protected $table = 'materiel_tasks';

    protected $fillable = [
        'site_id', 'language_code', 'type', 'h1', 'path', 'slogan', 'seo_title', 'seo_desc', 'content', 'category_id'
    ];

    // 类型常量
    const TYPE_HOME = 1;
    const TYPE_ABOUT = 2;
    const TYPE_CONTACT = 3;
    const TYPE_POLICY = 4;
    const TYPE_LOGO = 5;
    const TYPE_ICON = 6;
    const TYPE_TERMS = 7;
    const TYPE_CATEGORY =8;



    public static function LANGUAGES() {
        return ['en'=>'English', 'de'=>'Deutsch', 'fr'=>'Français', 'es'=>'Español'];
    }

    public static function SUPPORTS($locale) {
        $support = [
            'en' => [
                2 => ['name'=>'About', 'uri'=>'about'],
                3 => ['name'=>'Contact', 'uri'=>'contact'],
                4 => ['name'=>'Privacy', 'uri'=>'privacy'],
                7 => ['name'=>'Terms', 'uri'=>'terms']
            ],
            'de' => [
                2 => ['name'=>'Über uns', 'uri'=>'about'],
                3 => ['name'=>'Kontakt', 'uri'=>'contact'],
                4 => ['name'=>'Datenschutz', 'uri'=>'privacy'],
                7 => ['name'=>'Bedingungen', 'uri'=>'terms']
            ],
            'fr' => [
                2 => ['name'=>'À propos', 'uri'=>'about'],
                3 => ['name'=>'Contact', 'uri'=>'contact'],
                4 => ['name'=>'Confidentialité', 'uri'=>'privacy'],
                7 => ['name'=>'Conditions', 'uri'=>'terms']
            ],
            'es' => [
                2 => ['name'=>'Acerca de', 'uri'=>'about'],
                3 => ['name'=>'Contacto', 'uri'=>'contact'],
                4 => ['name'=>'Privacidad', 'uri'=>'privacy'],
                7 => ['name'=>'Términos', 'uri'=>'terms']
            ]
        ];
        return data_get($support, $locale, []);
    }


    public static function home($locale) {
        $home = [
            'en' => 'Home',
            'de' => 'Startseite',
            'fr' => 'Accueil',
            'es' => 'Inicio',
        ];
        return data_get($home, $locale, '');
    }

    public static function recent_posts($locale) {
        $recent_posts = [
            'en' => 'Recent Posts',
            'de' => 'Neueste Beiträge',
            'fr' => 'Articles Récents',
            'es' => 'Publicaciones Recientes'
        ];
        return data_get($recent_posts, $locale, '');
    }

    public static function related_posts($locale) {
        $related_posts = [
            'en'=>'Related Posts',
            'de'=>'Verwandte Beiträge',
            'fr'=>'Articles connexes',
            'es'=>'Publicaciones relacionadas'
        ];
        return data_get($related_posts, $locale, '');
    }

    public static function read_article($locale) {
        $read_article = [
            'en' => 'Read Article',
            'de' => 'Artikel lesen',
            'fr' => 'Lire l’article',
            'es' => 'Leer el artículo'
        ];
        return data_get($read_article, $locale, '');
    }

    public static function hot_topics($locale) {
        $hot_topics = [
            'en' => 'Hot Topics',
            'de' => 'Aktuelle Themen',
            'fr' => 'Sujets populaires',
            'es' => 'Temas candentes'
        ];
        return data_get($hot_topics, $locale, '');
    }

    public static function page_not_found($locale) {
        $page_not_found = [
            'en' => 'Oops! Page Not Found',
            'de' => 'Ups! Seite nicht gefunden',
            'fr' => 'Oups ! Page introuvable',
            'es' => '¡Ups! Página no encontrada'
        ];
        return data_get($page_not_found, $locale, '');
    }

    public static function desc_1_404($locale) {
        $desc_1_404 = [
            'en' => "The page you're looking for seems to have gone on a training run and hasn't come back yet.",
            'de' => "Die Seite, die du suchst, scheint zu einer Trainingsrunde aufgebrochen zu sein und ist noch nicht zurück.",
            'fr' => "La page que vous recherchez semble être partie faire un entraînement et n’est pas encore revenue.",
            'es' => "La página que buscas parece haberse ido a hacer un entrenamiento y aún no ha regresado."
        ];
        return data_get($desc_1_404, $locale, '');
    }

    public static function desc_2_404($locale) {
        $desc_2_404 = [
            'en' => "Don't worry, there are plenty of other great places to explore!",
            'de' => "Keine Sorge, es gibt noch viele andere großartige Seiten zu entdecken!",
            'fr' => "Ne vous inquiétez pas, il y a plein d’autres endroits intéressants à découvrir !",
            'es' => "No te preocupes, ¡hay muchos otros lugares increíbles por explorar!"
        ];
        return data_get($desc_2_404, $locale, '');
    }

    public static function go_to_homepage($locale) {
        $go_to_homepage = [
            'en'=>'Go to Homepage',
            'de'=>'Zur Startseite',
            'fr'=>'Aller à l’accueil',
            'es'=>'Ir a la página de inicio'
        ];
        return data_get($go_to_homepage, $locale, '');
    }

    public static function popular_destinations($locale) {
        $popular_destinations = [
            'en'=>'Popular Destinations',
            'de'=>'Beliebte Themen',
            'fr'=>'Destinations populaires',
            'es'=>'Destinos populares'
        ];
        return data_get($popular_destinations, $locale, '');
    }

    public static function detail_content($locale) {
        $detail_content = [
            'en'=>'Content',
            'de'=>'Inhalt',
            'fr'=>'Contenu',
            'es'=>'Contenido'
        ];
        return data_get($detail_content, $locale, '');
    }

    public static function popular_articles($locale) {
        $popular_articles = [
            'en'=>'Popular Articles',
            'de'=>'Beliebte Artikel',
            'fr'=>'Articles populaires',
            'es'=>'Artículos populares'
        ];
        return data_get($popular_articles, $locale, '');
    }

    public static function contact_us($locale) {
        $contact_us = [
            'en'=>'Contact Us',
            'de'=>'Kontaktieren Sie uns',
            'fr'=>'Contactez-nous',
            'es'=>'Contáctanos'
        ];
        return data_get($contact_us, $locale, '');
    }

    public static function contact_us_desc($locale) {
        $contact_us_desc = [
            'en'=>"Have questions? We're here to help!",
            'de'=>"Haben Sie Fragen? Wir sind für Sie da!",
            'fr'=>'Des questions ? Nous sommes là pour vous aider !',
            'es'=>'¿Tienes preguntas? ¡Estamos aquí para ayudarte!'
        ];
        return data_get($contact_us_desc, $locale, '');
    }

    public static function get_in_touch($locale) {
        $get_in_touch = [
            'en'=>'Get in Touch',
            'de'=>'Kontakt aufnehmen',
            'fr'=>'Entrer en contact',
            'es'=>'Ponte en contacto'
        ];
        return data_get($get_in_touch, $locale, '');
    }

    public static function office_topics($locale) {
        $office_topics = [
            'en'=>'Office Topics',
            'de'=>'Bürothemen',
            'fr'=>'Thèmes de Bureau',
            'es'=>'Temas de Oficina'
        ];
        return data_get($office_topics, $locale, '');
    }

    public static function copyright($locale) {
        $copyright = [
            'en'=>'All rights reserved.',
            'de'=>'Alle Rechte vorbehalten.',
            'fr'=>'Tous droits réservés.',
            'es'=>'Todos los derechos reservados.'
        ];
        return data_get($copyright, $locale, '');
    }

    public static function slogan($locale) {
        $copyright = [
            'en'=>'All the How-To Answers You Need.',
            'de'=>'Alle Anleitungen, die Sie brauchen.',
            'fr'=>'Toutes les réponses pratiques dont vous avez besoin.',
            'es'=>'Todas las respuestas prácticas que necesitas.'
        ];
        return data_get($copyright, $locale, '');
    }

    public static function homeH1($locale) {
        $homeH1 = [
            'en'=>'How Encyclopedia - All the How-To Answers You Need.',
            'de'=>'How Encyclopedia - Alle Anleitungen, die Sie brauchen.',
            'fr'=>'How Encyclopedia - Toutes les réponses pratiques dont vous avez besoin.',
            'es'=>'How Encyclopedia - Todas las respuestas prácticas que necesitas.'
        ];
        return data_get($homeH1, $locale, '');
    }

    public static function heroDesc($locale) {
        $heroDesc = [
            'en'=>'Clear, step-by-step guides, practical tips, and everyday knowledge for life skills, common problems, and useful how-to topics, all in one place.',
            'de'=>'Klare Schritt-für-Schritt-Anleitungen, praktische Tipps und Alltagswissen zu Lebenskompetenzen, häufigen Problemen und nützlichen How-to-Themen – alles an einem Ort.',
            'fr'=>'.Des guides clairs, étape par étape, des conseils pratiques et des connaissances du quotidien pour les compétences de la vie, les problèmes courants et des sujets pratiques, le tout en un seul endroit.',
            'es'=>'Guías claras paso a paso, consejos prácticos y conocimientos cotidianos sobre habilidades para la vida, problemas comunes y temas útiles de tipo “how-to”, todo en un solo lugar.'
        ];
        return data_get($heroDesc, $locale, '');
    }

    public static function company($locale) {
        $company = [
            'en' => 'Company',
            'de' => 'Unternehmen',
            'fr' => 'Entreprise',
            'es' => 'Empresa',
        ];
        return data_get($company, $locale, '');
    }

    public static function resource($locale) {
        $resource = [
            'en' => 'Resource',
            'de' => 'Ressourcen',
            'fr' => 'Ressources',
            'es' => 'Recursos',
        ];
        return data_get($resource, $locale, '');
    }

    public static function legal($locale) {
        $legal = [
            'en' => 'Legal',
            'de' => 'Rechtliche',
            'fr' => 'Juridique',
            'es' => 'Jurídico',
        ];
        return data_get($legal, $locale, '');
    }

    public static function by($locale) {
        $by = [
            'en' => 'By',
            'de' => 'Von',
            'fr' => 'Par',
            'es' => 'Por',
        ];
        return data_get($by, $locale, '');
    }

    public static function detailPublished($locale) {
        $detailPublished = [
            'en' => 'Published',
            'de' => 'Veröffentlicht',
            'fr' => 'Publié',
            'es' => 'Publicado',
        ];
        return data_get($detailPublished, $locale, '');
    }

    public static function filedUnder($locale) {
        $filedUnder = [
            'en' => 'Filed under',
            'de' => 'Abgelegt unter',
            'fr' => 'Classé sous',
            'es' => 'Archivado en',
        ];
        return data_get($filedUnder, $locale, '');
    }

    // 查询作用域 - 按语言过滤
    public function scopeByLanguage($query, $language)
    {
        return $query->where('language_code', $language);
    }

    // 查询作用域 - 按类型过滤
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }
}
