<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="dark">

<head>
    <?php
        $setting = \Helper::getSetting(); // ou Setting::first()
        // caminho padrão do favicon
        $favicon = $setting->software_favicon
                ? asset('storage/' . ltrim($setting->software_favicon, '/'))
                : asset('storage/icon/icon-padrao.webp');
        // canonical: usa override em setting ou URL atual
        $canonical = $setting->site_url
                ? rtrim($setting->site_url, '/')
                : url()->current();
    ?>

    <!-- Meta Tags Básicas -->
    <link rel="shortcut icon" href="<?php echo e($favicon); ?>" type="image/x-icon">
    <link rel="apple-touch-icon" href="<?php echo e($favicon); ?>" type="image/x-icon">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


    <!-- Meta Tags Essenciais -->
    <title><?php echo e($setting->software_name); ?></title>
    <meta name="description" content="<?php echo e($setting->meta_description); ?>">

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e($favicon); ?>">

    <!-- SEO Keywords -->
    <meta name="keywords" content="<?php echo e($setting->meta_keywords); ?>">

    <!-- Open Graph / Facebook -->
    <meta property="og:title"       content="<?php echo e($setting->og_title); ?>">
    <meta property="og:description" content="<?php echo e($setting->og_description); ?>">
    <meta property="og:image"       content="<?php echo e(asset('storage/' . ltrim($setting->software_favicon, '/'))); ?>">
    <meta property="og:url"         content="<?php echo e($canonical); ?>">
    <meta property="og:site_name"   content="<?php echo e($setting->software_name); ?>">

    <!-- Twitter -->
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="<?php echo e($setting->twitter_title); ?>">
    <meta name="twitter:description" content="<?php echo e($setting->twitter_description); ?>">
    <meta name="twitter:image"       content="<?php echo e(asset('storage/' . ltrim($setting->software_favicon, '/'))); ?>">

    <!-- Robots (Indexação) -->
    <meta name="robots" content="<?php echo e($setting->allow_indexing ? 'index,follow' : 'noindex,nofollow'); ?>">
    <meta name="googlebot" content="<?php echo e($setting->allow_indexing ? 'index,follow' : 'noindex,nofollow'); ?>">

    <!-- Canonical -->
    <link rel="canonical" href="<?php echo e($canonical); ?>">


    <link rel="stylesheet" href="<?php echo e(asset('assets/css/fontawesome.min.css')); ?>">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700&family=Roboto+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100&display=swap"
        rel="stylesheet">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <?php $custom = \Helper::getCustom(); ?>

    <!-- Meta Pixel Code -->
    <?php if(!empty($custom->idPixelFC)): ?>
        <script>
            !function(f,b,e,v,n,t,s){
                if (f.fbq) return;
                n = f.fbq = function(){ n.callMethod ? n.callMethod.apply(n,arguments) : n.queue.push(arguments) };
                if (!f._fbq) f._fbq = n;
                n.push = n; n.loaded = true; n.version = '2.0'; n.queue = [];
                t = b.createElement(e); t.async = true;
                t.src = v; s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s);
            }(window, document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '<?php echo e($custom->idPixelFC); ?>');
            fbq('track', 'PageView');
        </script>
        <noscript>
            <img height="1" width="1" style="display:none"
                src="https://www.facebook.com/tr?id=<?php echo e($custom->idPixelFC); ?>&ev=PageView&noscript=1" />
        </noscript>
    <?php endif; ?>
    <!-- End Meta Pixel Code -->

    <?php if(!empty($custom?->idPixelGoogle)): ?>
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo e(rawurlencode($custom->idPixelGoogle)); ?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '<?php echo e($custom->idPixelGoogle); ?>', { anonymize_ip: true });
        </script>
    <?php endif; ?>

    <style>
        body {
            font-family:
                <?php echo e($custom['font_family_default'] ?? "'Roboto Condensed', sans-serif"); ?>

            ;
        }

        :root {

            /*/////////////////////////////////////////////////////////////////
            ///////////////////////// CENTRAL DE DISIGN /////////////////////////
            /////////////////////////////////////////////////////////////////////

            //////////////////////////////////////////////////////////////// 
            ///////////// PAGINA FOOTER   | FICA EM BAIXO DO SITE ///// */


            --footer-background:
                <?php echo e($custom['footer_background']); ?>

            ;
            --footer-text-color:
                <?php echo e($custom['footer_text_color']); ?>

            ;
            --footer-links:
                <?php echo e($custom['footer_links']); ?>

            ;
            --footer-button-background:
                <?php echo e($custom['footer_button_background']); ?>

            ;
            --footer-button-text:
                <?php echo e($custom['footer_button_text']); ?>

            ;
            --footer-button-border:
                <?php echo e($custom['footer_button_border']); ?>

            ;
            --footer-icons:
                <?php echo e($custom['footer_icons']); ?>

            ;
            --footer-titulos:
                <?php echo e($custom['footer_titulos']); ?>

            ;
            --footer-button-hover-language:
                <?php echo e($custom['footer_button_hover_language']); ?>

            ;
            --footer-button-color-language:
                <?php echo e($custom['footer_button_color_language']); ?>

            ;
            --footer-button-background-language:
                <?php echo e($custom['footer_button_background_language']); ?>

            ;
            --footer-button-border-language:
                <?php echo e($custom['footer_button_border_language']); ?>

            ;
            --footer-background-language:
                <?php echo e($custom['footer_background_language']); ?>

            ;

            /* //////////////////////////////////////////////////////////////// */
            /* /////////// PAGINA SIDEBAR   | FICA NA LATERAL DO SITE////////// */
            /* //////////////////////////////////////////////////////////////// */

            --sidebar-background:
                <?php echo e($custom['sidebar_background']); ?>

            ;
            --sidebar-button-missoes-background:
                <?php echo e($custom['sidebar_button_missoes_background']); ?>

            ;
            --sidebar-button-vip-background:
                <?php echo e($custom['sidebar_button_vip_background']); ?>

            ;
            --sidebar-button-ganhe-background:
                <?php echo e($custom['sidebar_button_ganhe_background']); ?>

            ;
            --sidebar-button-bonus-background:
                <?php echo e($custom['sidebar_button_bonus_background']); ?>

            ;
            --sidebar-button-missoes-text:
                <?php echo e($custom['sidebar_button_missoes_text']); ?>

            ;
            --sidebar-button-ganhe-text:
                <?php echo e($custom['sidebar_button_ganhe_text']); ?>

            ;
            --sidebar-button-vip-text:
                <?php echo e($custom['sidebar_button_vip_text']); ?>

            ;
            --sidebar-button-hover:
                <?php echo e($custom['sidebar_button_hover']); ?>

            ;
            --sidebar-text-hover:
                <?php echo e($custom['sidebar_text_hover']); ?>

            ;
            --sidebar-text-color:
                <?php echo e($custom['sidebar_text_color']); ?>

            ;
            --sidebar-border:
                <?php echo e($custom['sidebar_border']); ?>

            ;
            --sidebar-icons:
                <?php echo e($custom['sidebar_icons']); ?>

            ;
            --sidebar_icons_background:
                <?php echo e($custom['sidebar_icons_background']); ?>

            ;





            /*///////////////////////////////////////////////////////////////// */



            /* //////////////////////////////////////////////////////////////// */
            /* /////////// PAGINA NAVHAR   | FICA EM CIMA DO SITE////////// */
            /* //////////////////////////////////////////////////////////////// */


            --navbar-background:
                <?php echo e($custom['navbar_background']); ?>

            ;
            --navbar-text:
                <?php echo e($custom['navbar_text']); ?>

            ;
            --navbar-icon-menu:
                <?php echo e($custom['navbar_icon_menu']); ?>

            ;
            --navbar-icon-promocoes:
                <?php echo e($custom['navbar_icon_promocoes']); ?>

            ;
            --navbar-icon-casino:
                <?php echo e($custom['navbar_icon_casino']); ?>

            ;
            --navbar-icon-sport:
                <?php echo e($custom['navbar_icon_sport']); ?>

            ;
            --navbar-button-text-login:
                <?php echo e($custom['navbar_button_text_login']); ?>

            ;
            --navbar-button-text-registro:
                <?php echo e($custom['navbar_button_text_registro']); ?>

            ;
            --navbar-button-background-login:
                <?php echo e($custom['navbar_button_background_login']); ?>

            ;
            --navbar-button-background-registro:
                <?php echo e($custom['navbar_button_background_registro']); ?>

            ;
            --navbar-button-border-color:
                <?php echo e($custom['navbar_button_border_color']); ?>

            ;
            --navbar-button-text-superior:
                <?php echo e($custom['navbar_button_text_superior']); ?>

            ;
            --navbar-button-background-superior:
                <?php echo e($custom['navbar_button_background_superior']); ?>

            ;
            --navbar-text-superior:
                <?php echo e($custom['navbar_text_superior']); ?>

            ;
            --navbar_button_deposito_background:
                <?php echo e($custom['navbar_button_deposito_background']); ?>

            ;
            --navbar_button_deposito_text_color:
                <?php echo e($custom['navbar_button_deposito_text_color']); ?>

            ;
            --navbar_button_deposito_border_color:
                <?php echo e($custom['navbar_button_deposito_border_color']); ?>

            ;

            --navbar_button_deposito_píx_color_text:
                <?php echo e($custom['navbar_button_deposito_píx_color_text']); ?>

            ;
            --navbar_button_deposito_píx_background:
                <?php echo e($custom['navbar_button_deposito_píx_background']); ?>

            ;
            --navbar_button_deposito_píx_icon:
                <?php echo e($custom['navbar_button_deposito_píx_icon']); ?>

            ;

            --navbar_button_carteira_background:
                <?php echo e($custom['navbar_button_carteira_background']); ?>

            ;
            --navbar_button_carteira_text_color:
                <?php echo e($custom['navbar_button_carteira_text_color']); ?>

            ;
            --navbar_button_carteira_border_color:
                <?php echo e($custom['navbar_button_carteira_border_color']); ?>

            ;

            --navbar_perfil_text_color:
                <?php echo e($custom['navbar_perfil_text_color']); ?>

            ;
            --navbar_perfil_background:
                <?php echo e($custom['navbar_perfil_background']); ?>

            ;
            --navbar_perfil_icon_color:
                <?php echo e($custom['navbar_perfil_icon_color']); ?>

            ;

            --navbar_perfil_icon_color_border:
                <?php echo e($custom['navbar_perfil_icon_color_border']); ?>

            ;
            --navbar_perfil_modal_icon_color:
                <?php echo e($custom['navbar_perfil_modal_icon_color']); ?>

            ;
            --navbar_perfil_modal_text_modal:
                <?php echo e($custom['navbar_perfil_modal_text_modal']); ?>

            ;
            --navbar_perfil_modal_background_modal:
                <?php echo e($custom['navbar_perfil_modal_background_modal']); ?>

            ;
            --navbar_perfil_modal_hover_modal:
                <?php echo e($custom['navbar_perfil_modal_hover_modal']); ?>

            ;
            --navbar_icon_promocoes_segunda_cor:
                <?php echo e($custom['navbar_icon_promocoes_segunda_cor']); ?>

            ;




            /*///////////////////////////////////////////////////////////////// */



            /* //////////////////////////////////////////////////////////////// */
            /* /////////// PAGINA HOME   | PAGINA PRINCIPAL DO SITE////////// */
            /* //////////////////////////////////////////////////////////////// */



            --home_background_button_banner:
                <?php echo e($custom['home_background_button_banner']); ?>

            ;
            --home_icon_color_button_banner:
                <?php echo e($custom['home_icon_color_button_banner']); ?>

            ;
            --home_background_categorias:
                <?php echo e($custom['home_background_categorias']); ?>

            ;
            --home_text_color_categorias:
                <?php echo e($custom['home_text_color_categorias']); ?>

            ;


            --topo_icon_color:
                <?php echo e($custom['topo_icon_color']); ?>

            ;
            --topo_button_text_color:
                <?php echo e($custom['topo_button_text_color']); ?>

            ;
            --topo_button_background:
                <?php echo e($custom['topo_button_background']); ?>

            ;
            --topo_button_border_color:
                <?php echo e($custom['topo_button_border_color']); ?>

            ;

            --home_background_pesquisa:
                <?php echo e($custom['home_background_pesquisa']); ?>

            ;
            --home_text_color_pesquisa:
                <?php echo e($custom['home_text_color_pesquisa']); ?>

            ;
            --home_background_pesquisa_aviso:
                <?php echo e($custom['home_background_pesquisa_aviso']); ?>

            ;
            --home_text_color_pesquisa_aviso:
                <?php echo e($custom['home_text_color_pesquisa_aviso']); ?>

            ;
            --home_background_button_pesquisa:
                <?php echo e($custom['home_background_button_pesquisa']); ?>

            ;
            --home_icon_color_button_pesquisa:
                <?php echo e($custom['home_icon_color_button_pesquisa']); ?>

            ;


            --home_background_button_vertodos:
                <?php echo e($custom['home_background_button_vertodos']); ?>

            ;
            --home_text_color_button_vertodos:
                <?php echo e($custom['home_text_color_button_vertodos']); ?>

            ;
            --home_background_button_jogar:
                <?php echo e($custom['home_background_button_jogar']); ?>

            ;
            --home_text_color_button_jogar:
                <?php echo e($custom['home_text_color_button_jogar']); ?>

            ;
            --home_icon_color_button_jogar:
                <?php echo e($custom['home_icon_color_button_jogar']); ?>

            ;
            --home_hover_jogar:
                <?php echo e($custom['home_hover_jogar']); ?>

            ;
            --home_text_color:
                <?php echo e($custom['home_text_color']); ?>

            ;
            --home_background:
                <?php echo e($custom['home_background']); ?>

            ;

            --home_background_input_pesquisa:
                <?php echo e($custom['home_background_input_pesquisa']); ?>

            ;
            --home_icon_color_input_pesquisa:
                <?php echo e($custom['home_icon_color_input_pesquisa']); ?>

            ;
            --home_border_color_input_pesquisa:
                <?php echo e($custom['home_border_color_input_pesquisa']); ?>

            ;



            /* //////////////////////////////////////////////////////////////// */
            /* /////////// PAGINA LISTGAME   | PAGINA DE LISTAGEM DE JOGOS////////// */
            /* //////////////////////////////////////////////////////////////// */

            --gamelist_background:
                <?php echo e($custom['gamelist_background']); ?>

            ;
            --gamelist_input_background:
                <?php echo e($custom['gamelist_input_background']); ?>

            ;
            --gamelist_input_text_color:
                <?php echo e($custom['gamelist_input_text_color']); ?>

            ;
            --gamelist_input_border_color:
                <?php echo e($custom['gamelist_input_border_color']); ?>

            ;
            --gamelist_text_color:
                <?php echo e($custom['gamelist_text_color']); ?>

            ;
            --gamelist_button_background:
                <?php echo e($custom['gamelist_button_background']); ?>

            ;
            --gamelist_button_text_color:
                <?php echo e($custom['gamelist_button_text_color']); ?>

            ;
            --gamelist_button_border_color:
                <?php echo e($custom['gamelist_button_border_color']); ?>

            ;


            /* //////////////////////////////////////////////////////////////// */
            /* /////////// PAGINA LOGIN - RESGISTRO E ESQUECI A SENHA   /////// */
            /* //////////////////////////////////////////////////////////////// */
            --register_background:
                <?php echo e($custom['register_background']); ?>

            ;
            --register_text_color:
                <?php echo e($custom['register_text_color']); ?>

            ;
            --register_links_color:
                <?php echo e($custom['register_links_color']); ?>

            ;
            --register_input_background:
                <?php echo e($custom['register_input_background']); ?>

            ;
            --register_input_text_color:
                <?php echo e($custom['register_input_text_color']); ?>

            ;
            --register_input_border_color:
                <?php echo e($custom['register_input_border_color']); ?>

            ;
            --register_button_text_color:
                <?php echo e($custom['register_button_text_color']); ?>

            ;
            --register_button_background:
                <?php echo e($custom['register_button_background']); ?>

            ;
            --register_button_border_color:
                <?php echo e($custom['register_button_border_color']); ?>

            ;
            --geral_icons_color:
                <?php echo e($custom['geral_icons_color']); ?>

            ;
            --register_security_color:
                <?php echo e($custom['register_security_color']); ?>

            ;
            --register_security_background:
                <?php echo e($custom['register_security_background']); ?>

            ;
            --register_security_border-color:
                <?php echo e($custom['register_security_border_color']); ?>

            ;


            --login_background:
                <?php echo e($custom['login_background']); ?>

            ;
            --login_text_color:
                <?php echo e($custom['login_text_color']); ?>

            ;
            --login_links_color:
                <?php echo e($custom['login_links_color']); ?>

            ;
            --login_input_background:
                <?php echo e($custom['login_input_background']); ?>

            ;
            --login_input_text_color:
                <?php echo e($custom['login_input_text_color']); ?>

            ;
            --login_input_border_color:
                <?php echo e($custom['login_input_border_color']); ?>

            ;
            --login_button_text_color:
                <?php echo e($custom['login_button_text_color']); ?>

            ;
            --login_button_background:
                <?php echo e($custom['login_button_background']); ?>

            ;
            --login_button_border_color:
                <?php echo e($custom['login_button_border_color']); ?>

            ;

            --esqueci_background:
                <?php echo e($custom['esqueci_background']); ?>

            ;
            --esqueci_text_color:
                <?php echo e($custom['esqueci_text_color']); ?>

            ;
            --esqueci_input_background:
                <?php echo e($custom['esqueci_input_background']); ?>

            ;
            --esqueci_input_text_color:
                <?php echo e($custom['esqueci_input_text_color']); ?>

            ;
            --esqueci_input_border_color:
                <?php echo e($custom['esqueci_input_border_color']); ?>

            ;
            --esqueci_button_text_color:
                <?php echo e($custom['esqueci_button_text_color']); ?>

            ;
            --esqueci_button_background:
                <?php echo e($custom['esqueci_button_background']); ?>

            ;
            --esqueci_button_border_color:
                <?php echo e($custom['esqueci_button_border_color']); ?>

            ;


            /* //////////////////////////////////////////////////////////////// */
            /* /////////// PAGINA AFFILIATE   | PAGINA DE AFILIADOS////////// */
            /* //////////////////////////////////////////////////////////////// */


            --affiliates_background:
                <?php echo e($custom['affiliates_background']); ?>

            ;
            --affiliates_sub_background:
                <?php echo e($custom['affiliates_sub_background']); ?>

            ;
            --affiliates_text_color:
                <?php echo e($custom['affiliates_text_color']); ?>

            ;
            --affiliates_numero_color:
                <?php echo e($custom['affiliates_numero_color']); ?>

            ;
            --affiliates_button_saque_background:
                <?php echo e($custom['affiliates_button_saque_background']); ?>

            ;
            --affiliates_button_saque_text:
                <?php echo e($custom['affiliates_button_saque_text']); ?>

            ;
            --affiliates_button_copie_background:
                <?php echo e($custom['affiliates_button_copie_background']); ?>

            ;
            --affiliates_button_copie_text:
                <?php echo e($custom['affiliates_button_copie_text']); ?>

            ;
            --affiliates_icom_color:
                <?php echo e($custom['affiliates_icom_color']); ?>

            ;


            /* //////////////////////////////////////////////////////////////// */
            /* /////////// PAGINA CART   | PAGINA DE  DE COMPRAS     ////////// */
            /* //////////////////////////////////////////////////////////////// */

            --carteira_button_background:
                <?php echo e($custom['carteira_button_background']); ?>

            ;
            --carteira_button_text_color:
                <?php echo e($custom['carteira_button_text_color']); ?>

            ;
            --carteira_button_border_color:
                <?php echo e($custom['carteira_button_border_color']); ?>

            ;
            --carteira_icon_color:
                <?php echo e($custom['carteira_icon_color']); ?>

            ;
            --carteira_text_color:
                <?php echo e($custom['carteira_text_color']); ?>

            ;
            --carteira_background:
                <?php echo e($custom['carteira_background']); ?>

            ;

            --carteira_saldo_background:
                <?php echo e($custom['carteira_saldo_background']); ?>

            ;
            --carteira_saldo_text_color:
                <?php echo e($custom['carteira_saldo_text_color']); ?>

            ;
            --carteira_saldo_border_color:
                <?php echo e($custom['carteira_saldo_border_color']); ?>

            ;
            --carteira_saldo_title_color:
                <?php echo e($custom['carteira_saldo_title_color']); ?>

            ;
            --carteira_saldo_icon_color:
                <?php echo e($custom['carteira_saldo_icon_color']); ?>

            ;
            --carteira_saldo_number_color:
                <?php echo e($custom['carteira_saldo_number_color']); ?>

            ;
            --carteira_saldo_button_deposito_background:
                <?php echo e($custom['carteira_saldo_button_deposito_background']); ?>

            ;
            --carteira_saldo_button_saque_background:
                <?php echo e($custom['carteira_saldo_button_saque_background']); ?>

            ;
            --carteira_saldo_button_deposito_text_color:
                <?php echo e($custom['carteira_saldo_button_deposito_text_color']); ?>

            ;
            --carteira_saldo_button_saque_text_color:
                <?php echo e($custom['carteira_saldo_button_saque_text_color']); ?>

            ;

            --carteira_deposito_background:
                <?php echo e($custom['carteira_deposito_background']); ?>

            ;
            --carteira_deposito_contagem_background:
                <?php echo e($custom['carteira_deposito_contagem_background']); ?>

            ;
            --carteira_deposito_contagem_text_color:
                <?php echo e($custom['carteira_deposito_contagem_text_color']); ?>

            ;
            --carteira_deposito_contagem_number_color:
                <?php echo e($custom['carteira_deposito_contagem_number_color']); ?>

            ;
            --carteira_deposito_contagem_quadrado_background:
                <?php echo e($custom['carteira_deposito_contagem_quadrado_background']); ?>

            ;
            --carteira_deposito_input_background:
                <?php echo e($custom['carteira_deposito_input_background']); ?>

            ;
            --carteira_deposito_input_text_color:
                <?php echo e($custom['carteira_deposito_input_text_color']); ?>

            ;
            --carteira_deposito_input_number_color:
                <?php echo e($custom['carteira_deposito_input_number_color']); ?>

            ;
            --carteira_deposito_input_border_color:
                <?php echo e($custom['carteira_deposito_input_border_color']); ?>

            ;
            --carteira_deposito_title_color:
                <?php echo e($custom['carteira_deposito_title_color']); ?>

            ;
            --carteira_deposito_number_color:
                <?php echo e($custom['carteira_deposito_number_color']); ?>

            ;
            --carteira_deposito_number_background:
                <?php echo e($custom['carteira_deposito_number_background']); ?>

            ;
            --carteira_deposito_button_background:
                <?php echo e($custom['carteira_deposito_button_background']); ?>

            ;
            --carteira_deposito_button_text_color:
                <?php echo e($custom['carteira_deposito_button_text_color']); ?>

            ;

            --carteira_saldo_pix_text_color:
                <?php echo e($custom['carteira_saldo_pix_text_color']); ?>

            ;
            --carteira_saldo_pix_sub_text_color:
                <?php echo e($custom['carteira_saldo_pix_sub_text_color']); ?>

            ;
            --carteira_saldo_pix_button_background:
                <?php echo e($custom['carteira_saldo_pix_button_background']); ?>

            ;
            --carteira_saldo_pix_button_text_color:
                <?php echo e($custom['carteira_saldo_pix_button_text_color']); ?>

            ;
            --carteira_saldo_pix_input_background:
                <?php echo e($custom['carteira_saldo_pix_input_background']); ?>

            ;
            --carteira_saldo_pix_input_text_color:
                <?php echo e($custom['carteira_saldo_pix_input_text_color']); ?>

            ;
            --carteira_saldo_pix_border_color:
                <?php echo e($custom['carteira_saldo_pix_border_color']); ?>

            ;
            --carteira_saldo_pix_icon_color:
                <?php echo e($custom['carteira_saldo_pix_icon_color']); ?>

            ;
            --carteira_saldo_pix_background:
                <?php echo e($custom['carteira_saldo_pix_background']); ?>

            ;




            --carteira_saque_background:
                <?php echo e($custom['carteira_saque_background']); ?>

            ;
            --carteira_saque_text_color:
                <?php echo e($custom['carteira_saque_text_color']); ?>

            ;
            --carteira_saque_number_color:
                <?php echo e($custom['carteira_saque_number_color']); ?>

            ;
            --carteira_saque_input_background:
                <?php echo e($custom['carteira_saque_input_background']); ?>

            ;
            --carteira_saque_input_text_color:
                <?php echo e($custom['carteira_saque_input_text_color']); ?>

            ;
            --carteira_saque_input_border_color:
                <?php echo e($custom['carteira_saque_input_border_color']); ?>

            ;
            --carteira_saque_button_text_color:
                <?php echo e($custom['carteira_saque_button_text_color']); ?>

            ;
            --carteira_saque_button_background:
                <?php echo e($custom['carteira_saque_button_background']); ?>

            ;
            --carteira_saque_icon_color:
                <?php echo e($custom['carteira_saque_icon_color']); ?>

            ;

            --carteira_history_background:
                <?php echo e($custom['carteira_history_background']); ?>

            ;
            --carteira_history_title_color:
                <?php echo e($custom['carteira_history_title_color']); ?>

            ;
            --carteira_history_text_color:
                <?php echo e($custom['carteira_history_text_color']); ?>

            ;
            --carteira_history_number_color:
                <?php echo e($custom['carteira_history_number_color']); ?>

            ;
            --carteira_history_status_finalizado_color:
                <?php echo e($custom['carteira_history_status_finalizado_color']); ?>

            ;
            --carteira_history_status_finalizado_background:
                <?php echo e($custom['carteira_history_status_finalizado_background']); ?>

            ;
            --carteira_history_status_pedente_color:
                <?php echo e($custom['carteira_history_status_pedente_color']); ?>

            ;
            --carteira_history_status_pedente_background:
                <?php echo e($custom['carteira_history_status_pedente_background']); ?>

            ;
            --carteira_history_barra_color:
                <?php echo e($custom['carteira_history_barra_color']); ?>

            ;
            --carteira_history_barra_text_color:
                <?php echo e($custom['carteira_history_barra_text_color']); ?>

            ;
            --carteira_history_icon_color:
                <?php echo e($custom['carteira_history_icon_color']); ?>

            ;
            --carteira_history_barra_background:
                <?php echo e($custom['carteira_history_barra_background']); ?>

            ;





            /* //////////////////////////////////////////////////////////////// */
            /* /////////// PAGINA VIP   | PAGINA DE VIP     ////////// */
            /* //////////////////////////////////////////////////////////////// */

            --vips_background:
                <?php echo e($custom['vips_background']); ?>

            ;
            --vips_title_color:
                <?php echo e($custom['vips_title_color']); ?>

            ;
            --vips_text_color:
                <?php echo e($custom['vips_text_color']); ?>

            ;
            --vips_description_color:
                <?php echo e($custom['vips_description_color']); ?>

            ;
            --vips_button_background:
                <?php echo e($custom['vips_button_background']); ?>

            ;
            --vips_button_text_color:
                <?php echo e($custom['vips_button_text_color']); ?>

            ;
            --vips_progress_background:
                <?php echo e($custom['vips_progress_background']); ?>

            ;
            --vips_progress_text_color:
                <?php echo e($custom['vips_progress_text_color']); ?>

            ;
            --vips_progress_prenchimento_background:
                <?php echo e($custom['vips_progress_prenchimento_background']); ?>

            ;
            --vips_icons_text_color:
                <?php echo e($custom['vips_icons_text_color']); ?>

            ;
            --vips_icons_background:
                <?php echo e($custom['vips_icons_background']); ?>

            ;
            --vips_icons_sub_text_color:
                <?php echo e($custom['vips_icons_sub_text_color']); ?>

            ;
            --vips_background_profile_vip:
                <?php echo e($custom['vips_background_profile_vip']); ?>

            ;
            --vips_icon_mover_color:
                <?php echo e($custom['vips_icon_mover_color']); ?>

            ;
            --vip_atual_background:
                <?php echo e($custom['vip_atual_background']); ?>

            ;
            --vip_atual_text_color:
                <?php echo e($custom['vip_atual_text_color']); ?>

            ;
            --vip_proximo_background:
                <?php echo e($custom['vip_proximo_background']); ?>

            ;
            --vip_proximo_text_color:
                <?php echo e($custom['vip_proximo_text_color']); ?>

            ;



            /* //////////////////////////////////////////////////////////////// */
            /* /////////// PAGINA PROMOCOES   | PAGINA DE PROMOCOES     ////////// */
            /* //////////////////////////////////////////////////////////////// */

            --promocoes_background:
                <?php echo e($custom['promocoes_background']); ?>

            ;
            --promocoes_title_color:
                <?php echo e($custom['promocoes_title_color']); ?>

            ;
            --promocoes_text_color:
                <?php echo e($custom['promocoes_text_color']); ?>

            ;
            --promocoes_sub_background:
                <?php echo e($custom['promocoes_sub_background']); ?>

            ;
            --promocoes_button_background:
                <?php echo e($custom['promocoes_button_background']); ?>

            ;
            --promocoes_button_text_color:
                <?php echo e($custom['promocoes_button_text_color']); ?>

            ;
            --promocoes_pupup_background:
                <?php echo e($custom['promocoes_pupup_background']); ?>

            ;
            --promocoes_pupup_text_color:
                <?php echo e($custom['promocoes_pupup_text_color']); ?>

            ;
            --promocoes_icon_color:
                <?php echo e($custom['promocoes_icon_color']); ?>

            ;



            /* //////////////////////////////////////////////////////////////// */
            /* /////////// PAGINA MISSOES   | PAGINA DE MISSOES     ////////// */
            /* //////////////////////////////////////////////////////////////// */



            --missoes_background:
                <?php echo e($custom['missoes_background']); ?>

            ;
            --missoes_sub_background:
                <?php echo e($custom['missoes_sub_background']); ?>

            ;
            --missoes_text_color:
                <?php echo e($custom['missoes_text_color']); ?>

            ;
            --missoes_title_color:
                <?php echo e($custom['missoes_title_color']); ?>

            ;
            --missoes_bonus_background:
                <?php echo e($custom['missoes_bonus_background']); ?>

            ;
            --missoes_bonus_text_color:
                <?php echo e($custom['missoes_bonus_text_color']); ?>

            ;
            --missoes_button_background:
                <?php echo e($custom['missoes_button_background']); ?>

            ;
            --missoes_button_text_color:
                <?php echo e($custom['missoes_button_text_color']); ?>

            ;
            --missoes_barraprogresso_background:
                <?php echo e($custom['missoes_barraprogresso_background']); ?>

            ;
            --missoes_barraprogresso_prenchimento_background:
                <?php echo e($custom['missoes_barraprogresso_prenchimento_background']); ?>

            ;
            --missoes_barraprogresso_text_color:
                <?php echo e($custom['missoes_barraprogresso_text_color']); ?>

            ;



            --background_geral:
                <?php echo e($custom['background_geral']); ?>

            ;
            --background_geral_text_color:
                <?php echo e($custom['background_geral_text_color']); ?>

            ;
            --carregando_background:
                <?php echo e($custom['carregando_background']); ?>

            ;
            --carregando_text_color:
                <?php echo e($custom['carregando_text_color']); ?>

            ;


            /* //////////////////////////////////////////////////////////////// */
            /* /////////// PAGINA COOKIES   | PAGINA DE COOKIES     ////////// */
            /* //////////////////////////////////////////////////////////////// */

            --popup_cookies_background:
                <?php echo e($custom['popup_cookies_background']); ?>

            ;
            --popup_cookies_text_color:
                <?php echo e($custom['popup_cookies_text_color']); ?>

            ;
            --popup_cookies_button_background:
                <?php echo e($custom['popup_cookies_button_background']); ?>

            ;
            --popup_cookies_button_text_color:
                <?php echo e($custom['popup_cookies_button_text_color']); ?>

            ;
            --popup_cookies_button_border_color:
                <?php echo e($custom['popup_cookies_button_border_color']); ?>

            ;


            /* //////////////////////////////////////////////////////////////// */
            /* /////////// PAGINA MENU CELULAR   | MENU CELULAR     ////////// */
            /* //////////////////////////////////////////////////////////////// */

            --menu_cell_background:
                <?php echo e($custom['menu_cell_background']); ?>

            ;
            --menu_cell_text_color:
                <?php echo e($custom['menu_cell_text_color']); ?>

            ;

            /* //////////////////////////////////////////////////////////////// */
            /* /////////// PAGINA SPORTE E TERMOS | TERMOS E SPORT  ////////// */
            /* //////////////////////////////////////////////////////////////// */

            --aviso_sport_background:
                <?php echo e($custom['aviso_sport_background']); ?>

            ;
            --aviso_sport_text_color:
                <?php echo e($custom['aviso_sport_text_color']); ?>

            ;
            --titulo_principal_termos:
                <?php echo e($custom['titulo_principal_termos']); ?>

            ;
            --titulo_segundario_termos:
                <?php echo e($custom['titulo_segundario_termos']); ?>

            ;
            --descriçao_segundario_termos:
                <?php echo e($custom['descriçao_segundario_termos']); ?>

            ;

            /*///////////////////////////////////////////////////////////////// */



            /* //////////////////////////////////////////////////////////////// */
            /* /////////// Modal  MY ACCOUNT | MINHA CONTA  ////////// */
            /* //////////////////////////////////////////////////////////////// */

            --myconta_background:
                <?php echo e($custom['myconta_background']); ?>

            ;
            --myconta_text_color:
                <?php echo e($custom['myconta_text_color']); ?>

            ;
            --myconta_button_background:
                <?php echo e($custom['myconta_button_background']); ?>

            ;
            --myconta_button_icon_color:
                <?php echo e($custom['myconta_button_icon_color']); ?>

            ;
            --myconta_sub_background:
                <?php echo e($custom['myconta_sub_background']); ?>

            ;


            /*///////////////////////////////////////////////////////////////// */


            /* //////////////////////////////////////////////////////////////// */
            /* /////////// Modal  MY ACCOUNT | MINHA CONTA  ////////// */
            /* //////////////////////////////////////////////////////////////// */

            --central_suporte_background:
                <?php echo e($custom['central_suporte_background']); ?>

            ;
            --central_suporte_sub_background:
                <?php echo e($custom['central_suporte_sub_background']); ?>

            ;
            --central_suporte_button_background_ao_vivo:
                <?php echo e($custom['central_suporte_button_background_ao_vivo']); ?>

            ;
            --central_suporte_button_texto_ao_vivo:
                <?php echo e($custom['central_suporte_button_texto_ao_vivo']); ?>

            ;
            --central_suporte_button_icon_ao_vivo:
                <?php echo e($custom['central_suporte_button_icon_ao_vivo']); ?>

            ;
            --central_suporte_button_background_denuncia:
                <?php echo e($custom['central_suporte_button_background_denuncia']); ?>

            ;
            --central_suporte_button_texto_denuncia:
                <?php echo e($custom['central_suporte_button_texto_denuncia']); ?>

            ;
            --central_suporte_button_icon_denuncia:
                <?php echo e($custom['central_suporte_button_icon_denuncia']); ?>

            ;
            --central_suporte_title_text_color:
                <?php echo e($custom['central_suporte_title_text_color']); ?>

            ;
            --central_suporte_icon_title_text_color:
                <?php echo e($custom['central_suporte_icon_title_text_color']); ?>

            ;
            --central_suporte_info_text_color:
                <?php echo e($custom['central_suporte_info_text_color']); ?>

            ;
            --central_suporte_info_icon_color:
                <?php echo e($custom['central_suporte_info_icon_color']); ?>

            ;
            --central_suporte_aviso_title_color:
                <?php echo e($custom['central_suporte_aviso_title_color']); ?>

            ;
            --central_suporte_aviso_text_color:
                <?php echo e($custom['central_suporte_aviso_text_color']); ?>

            ;
            --central_suporte_aviso_text_negrito_color:
                <?php echo e($custom['central_suporte_aviso_text_negrito_color']); ?>

            ;
            --central_suporte_aviso_icon_color:
                <?php echo e($custom['central_suporte_aviso_icon_color']); ?>

            ;

            /*///////////////////////////////////////////////////////////////// */
            --bonus_diario_texto:
                <?php echo e($custom['bonus_diario_texto']); ?>

            ;
            --bonus_diario_texto_icon:
                <?php echo e($custom['bonus_diario_texto_icon']); ?>

            ;
            --bonus_diario_texto_valor_bonus:
                <?php echo e($custom['bonus_diario_texto_valor_bonus']); ?>

            ;
            --bonus_diario_aviso:
                <?php echo e($custom['bonus_diario_aviso']); ?>

            ;
            --bonus_diario_botao_backgroud:
                <?php echo e($custom['bonus_diario_botao_backgroud']); ?>

            ;
            --bonus_diario_botao_texto_color:
                <?php echo e($custom['bonus_diario_botao_texto_color']); ?>

            ;
            --bonus_diario_regras_title:
                <?php echo e($custom['bonus_diario_regras_title']); ?>

            ;
            --bonus_diario_regras_titulo:
                <?php echo e($custom['bonus_diario_regras_titulo']); ?>

            ;
            --bonus_diario_bola_interna:
                <?php echo e($custom['bonus_diario_bola_interna']); ?>

            ;
            --bonus_diario_bola_fora_:
                <?php echo e($custom['bonus_diario_bola_fora_']); ?>

            ;
            --bonus_diario_bola_carregamento:
                <?php echo e($custom['bonus_diario_bola_carregamento']); ?>

            ;
            --bonus_diario_texto_bola:
                <?php echo e($custom['bonus_diario_texto_bola']); ?>

            ;
            --bonus_diario_background:
                <?php echo e($custom['bonus_diario_background']); ?>

            ;
            --bonus_diario_sub_background:
                <?php echo e($custom['bonus_diario_sub_background']); ?>

            ;

            /*///////////////////////////////////////////////////////////////// */

            /*/// MAIORES GANHOS*/

            --maiores-ganhos-background:
                <?php echo e($custom['maiores_ganhos_backgroud']); ?>

            ;
            --maiores-ganhos-sub-background:
                <?php echo e($custom['maiores_ganhos_sub_ackgroud']); ?>

            ;
            --maiores-ganhos-text-color:
                <?php echo e($custom['maiores_ganhos_texto_color']); ?>

            ;
            --maiores-ganhos-valor-color:
                <?php echo e($custom['maiores_ganhos_valor_color']); ?>

            ;

            /*///////////////////////////////////////////////////////////////// */
            /*/// Lives GANHOS*/
            --live-ganhos-background:
                <?php echo e($custom['live_ganhos_backgroud']); ?>

            ;
            --live-ganhos-sub-background:
                <?php echo e($custom['live_ganhos_sub_backgroud']); ?>

            ;
            --live-ganhos-text-color:
                <?php echo e($custom['live_ganhos_texto_color']); ?>

            ;
            --live-ganhos-apostas-color:
                <?php echo e($custom['live_ganhos_apostas_color']); ?>

            ;
            --live-ganhos-ganhos-color:
                <?php echo e($custom['live_ganhos_ganhos_color']); ?>

            ;
            --live-ganhos-border-color:
                <?php echo e($custom['live_ganhos_border_color']); ?>

            ;
            --live-ganhos-box-shadow-color:
                <?php echo e($custom['live_ganhos_box_shadow_color']); ?>

            ;
            /*///////////////////////////////////////////////////////////////// */
            /*/// Promoçao oferta GANHOS*/
            --rodadas-gratis-background:
                <?php echo e($custom['rodadas_gratis_background']); ?>

            ;
            --rodadas-gratis-border-color:
                <?php echo e($custom['rodadas_gratis_border_color']); ?>

            ;
            --rodadas-gratis-titulo-color:
                <?php echo e($custom['rodadas_gratis_titulo_color']); ?>

            ;
            --rodadas-gratis-titulo-background:
                <?php echo e($custom['rodadas_gratis_titulo_background']); ?>

            ;
            --rodadas-gratis-botao-color:
                <?php echo e($custom['rodadas_gratis_botao_color']); ?>

            ;
            --rodadas-gratis-botao-background:
                <?php echo e($custom['rodadas_gratis_botao_background']); ?>

            ;
            --rodadas-gratis-border-color-tabelas:
                <?php echo e($custom['rodadas_gratis_border_color_tabelas']); ?>

            ;
            --rodadas-gratis-color-texto1:
                <?php echo e($custom['rodadas_gratis_color_texto1']); ?>

            ;
            --rodadas-gratis-color-texto2:
                <?php echo e($custom['rodadas_gratis_color_texto2']); ?>

            ;
            
            /*///////////////////////////////////////////////////////////////// */
            --maior_de_18_background:
                <?php echo e($custom['maior_de_18_background']); ?>

            ;
            --maior_de_18_sub_background:
                <?php echo e($custom['maior_de_18_sub_background']); ?>

            ;
            --maior_de_18_texto_color:
                <?php echo e($custom['maior_de_18_texto_color']); ?>

            ;
            --maior_de_18_botao_sim_background:
                <?php echo e($custom['maior_de_18_botao_sim_background']); ?>

            ;
            --maior_de_18_botao_sim_texto_color:
                <?php echo e($custom['maior_de_18_botao_sim_texto_color']); ?>

            ;
            --maior_de_18_botao_nao_background:
                <?php echo e($custom['maior_de_18_botao_nao_background']); ?>

            ;
            --maior_de_18_botao_nao_texto_color:
                <?php echo e($custom['maior_de_18_botao_nao_texto_color']); ?>

            ;

            /*///////////////////////////////////////////////////////////////// */
            --pesquisar_homepage_background:
                <?php echo e($custom['pesquisar_homepage_background']); ?>

            ;
            --pesquisar_homepage_texto_color:
                <?php echo e($custom['pesquisar_homepage_texto_color']); ?>

            ;
            --pesquisar_homepage_icon_color:
                <?php echo e($custom['pesquisar_homepage_icon_color']); ?>

            ;
            --pesquisar_homepage_button_background:
                <?php echo e($custom['pesquisar_homepage_button_background']); ?>

            ;
            --pesquisar_homepage_button_text_color:
                <?php echo e($custom['pesquisar_homepage_button_text_color']); ?>

            ;
            /*///////////////////////////////////////////////////////////////// */

            --baixar_app_background:
                <?php echo e($custom['baixar_app_background']); ?>

            ;
            --baixar_app_sub_background:
                <?php echo e($custom['baixar_app_sub_background']); ?>

            ;
            --baixar_app_texto_color:
                <?php echo e($custom['baixar_app_texto_color']); ?>

            ;
            --baixar_app_explicacao_background:
                <?php echo e($custom['baixar_app_explicacao_background']); ?>

            ;
            --baixar_app_botao_background:
                <?php echo e($custom['baixar_app_botao_background']); ?>

            ;
            --baixar_app_botao_texto_color:
                <?php echo e($custom['baixar_app_botao_texto_color']); ?>

            ;


            /*///////////////////////////////////////////////////////////////// */

            
            /*///////////////////////////////////////////////////////////////// */
            --ci-primary-color:
                <?php echo e($custom['primary_color']); ?>

            ;
            --ci-primary-opacity-color:
                <?php echo e($custom['primary_opacity_color']); ?>

            ;
            --ci-secundary-color:
                <?php echo e($custom['secundary_color']); ?>

            ;
            --ci-gray-dark:
                <?php echo e($custom['gray_dark_color']); ?>

            ;
            --ci-gray-light:
                <?php echo e($custom['gray_light_color']); ?>

            ;
            --ci-gray-medium:
                <?php echo e($custom['gray_medium_color']); ?>

            ;
            --ci-gray-over:
                <?php echo e($custom['gray_over_color']); ?>

            ;
            --title-color:
                <?php echo e($custom['title_color']); ?>

            ;
            --text-color:
                <?php echo e($custom['text_color']); ?>

            ;
            --sub-text-color:
                <?php echo e($custom['sub_text_color']); ?>

            ;
            --placeholder-color:
                <?php echo e($custom['placeholder_color']); ?>

            ;
            --background-color:
                <?php echo e($custom['background_color']); ?>

            ;
            --standard-color: #1C1E22;
            --shadow-color: #111415;
            --page-shadow: linear-gradient(to right, #111415, rgba(17, 20, 21, 0));
            --autofill-color: #f5f6f7;
            --yellow-color: #FFBF39;
            --yellow-dark-color: #d7a026;
            --border-radius:
                <?php echo e($custom['border_radius']); ?>

            ;
            --tw-border-spacing-x: 0;
            --tw-border-spacing-y: 0;
            --tw-translate-x: 0;
            --tw-translate-y: 0;
            --tw-rotate: 0;
            --tw-skew-x: 0;
            --tw-skew-y: 0;
            --tw-scale-x: 1;
            --tw-scale-y: 1;
            --tw-scroll-snap-strictness: proximity;
            --tw-ring-offset-width: 0px;
            --tw-ring-offset-color: #fff;
            --tw-ring-color: rgba(59, 130, 246, .5);
            --tw-ring-offset-shadow: 0 0 #0000;
            --tw-ring-shadow: 0 0 #0000;
            --tw-shadow: 0 0 #0000;
            --tw-shadow-colored: 0 0 #0000;
            --input-primary:
                <?php echo e($custom['input_primary']); ?>

            ;
            --input-primary-dark:
                <?php echo e($custom['input_primary_dark']); ?>

            ;
            --carousel-banners:
                <?php echo e($custom['background_geral']); ?>

            ;
            --carousel-banners-dark:
                <?php echo e($custom['background_geral']); ?>

            ;
            --sidebar-color:
                <?php echo e($custom['background_geral']); ?>

            ;
            --sidebar-color-dark:
                <?php echo e($custom['background_geral']); ?>

            ;
            --navtop-color
            <?php echo e($custom['navtop_color']); ?>

            ;
            --navtop-color-dark:
                <?php echo e($custom['navtop_color_dark']); ?>

            ;
            --side-menu
            <?php echo e($custom['side_menu']); ?>

            ;
            --side-menu-dark:
                <?php echo e($custom['side_menu_dark']); ?>

            ;
            --footer-color
            <?php echo e($custom['footer_color']); ?>

            ;
            --footer-color-dark:
                <?php echo e($custom['footer_color_dark']); ?>

            ;
            --card-color
            <?php echo e($custom['card_color']); ?>

            ;
            --card-color-dark:
                <?php echo e($custom['card_color_dark']); ?>

            ;
            --card-color:
                <?php echo e($custom['card_color']); ?>

            ;
            --footer-color:
                <?php echo e($custom['footer_color']); ?>

            ;
            --side-menu-color:
                <?php echo e($custom['side_menu']); ?>

            ;
        }

        .navtop-color {
            background-color:
                <?php echo e($custom['background_geral']); ?>

            ;
        }

        :is(.dark .navtop-color) {
            background-color:
                <?php echo e($custom['background_geral']); ?>

            ;
        }

        .bg-base {
            background-color:
                <?php echo e($custom['background_geral']); ?>

            ;
        }

        :is(.dark .bg-base) {
            background-color:
                <?php echo e($custom['background_geral']); ?>

            ;
        }
    </style>

    <?php if(!empty($custom['custom_css'])): ?>
        <style>
            <?php echo $custom['custom_css']; ?>

        </style>
    <?php endif; ?>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>

<body color-theme="dark" class="text-gray-800 bg-base dark:text-gray-300 ">
    <div id="tourosbet"></div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/datepicker.min.js"></script>
    <script>
        window.Livewire?.on('copiado', (texto) => {
            navigator.clipboard.writeText(texto).then(() => {
                Livewire.emit('copiado');
            });
        });

        window._token = '<?php echo e(csrf_token()); ?>';
        //if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        if (localStorage.getItem('color-theme') === 'light') {
            document.documentElement.classList.remove('dark')
            document.documentElement.classList.add('light');
        } else {
            document.documentElement.classList.remove('light')
            document.documentElement.classList.add('dark')
        }
    </script>

    <?php if(!empty($custom['custom_js'])): ?>
        <script>
            <?php echo $custom['custom_js']; ?>

        </script>
    <?php endif; ?>
<?php if(! request()->cookie('maior18') && (!isset($custom['maior_de_18_status']) || $custom['maior_de_18_status'] == 1)): ?>
    <div
        id="age-popup"
        style="
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.7);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        "
    >
        <div style="
                width:90%; max-width:380px;
                background:<?php echo e($custom['maior_de_18_background']); ?>; border-radius:8px;
                box-shadow:0 0 10px #000;
                overflow:hidden; text-align:center;
            ">
            
            <div style="padding:1.5rem; background:<?php echo e($custom['maior_de_18_sub_background']); ?>;">
        <div style="
                width: 290px;
                height: 50px;
                margin:0 auto;
                background: url('<?php echo e(asset('storage/' . $setting->software_logo_white)); ?>') center/contain no-repeat;
        "></div>
            </div>
            
            <div style="padding:1.5rem; color:<?php echo e($custom['maior_de_18_texto_color']); ?>;">
                <div style="font-size:1.5rem; margin-bottom:1rem;">
                    Você tem mais de 18 anos?
                </div>
                <div style="display:flex; gap:1rem; justify-content:center;">
                    <button id="btn-no" style="
                            flex:1; padding:.75rem;
                            background:<?php echo e($custom['maior_de_18_botao_nao_background']); ?>; color:<?php echo e($custom['maior_de_18_botao_nao_texto_color']); ?>;
                            border:none; border-radius:4px;
                            display:flex; align-items:center;
                            justify-content:center; gap:.5rem;
                            cursor:pointer;
                        ">
                        <svg height="1em" viewBox="0 0 320 512" width="1em" xmlns="http://www.w3.org/2000/svg">
                            <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3
                                             0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3
                                             0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5
                                             12.5-12.5 32.8 0 45.3s32.8 12.5 45.3
                                             0L160 301.3 265.4 406.6c12.5 12.5 32.8
                                             12.5 45.3 0s12.5-32.8 0-45.3L205.3
                                             256 310.6 150.6z" fill="currentColor"/>
                        </svg>
                        Não
                    </button>
                    <button id="btn-yes" style="
                            flex:1; padding:.75rem;
                            background:<?php echo e($custom['maior_de_18_botao_sim_background']); ?>;
                            color:<?php echo e($custom['maior_de_18_botao_sim_texto_color']); ?>;
                            border:none; border-radius:4px;
                            display:flex; align-items:center;
                            justify-content:center; gap:.5rem;
                            cursor:pointer;
                        ">
                        <svg height="1em" viewBox="0 0 512 512" width="1em" xmlns="http://www.w3.org/2000/svg">
                            <path d="M470.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256
                                             256c-12.5 12.5-32.8 12.5-45.3
                                             0l-128-128c-12.5-12.5-12.5-32.8
                                             0-45.3s32.8-12.5 45.3
                                             0L192 338.7 425.4 105.4c12.5-12.5
                                             32.8-12.5 45.3 0z" fill="currentColor"/>
                        </svg>
                        Sim
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php echo $__env->yieldContent('content'); ?>

    <script>
        // só roda client-side
        window.addEventListener('load', () => {
            // se já tiver clicado em "Sim", não mostra nada
            if (localStorage.getItem('maior18') === '1') return;

            // espera 2s para garantir que o CSS external seja aplicado
            setTimeout(() => {
                document.getElementById('age-popup').style.display = 'flex';
            }, 4000); // agora é 2 segundos em vez de 5
        });

        document.getElementById('btn-yes').addEventListener('click', () => {
            // marca pra nunca mais exibir
            localStorage.setItem('maior18', '1');
            document.getElementById('age-popup').remove();
        });
        document.getElementById('btn-no').addEventListener('click', () => {
            window.location.href = 'https://google.com';
        });
    </script>
<?php endif; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Helper to check login status dynamically from DOM
            const checkIsLogged = () => {
                // Case insensitive check helper
                const hasText = (selector, texts) => {
                    const elements = Array.from(document.querySelectorAll(selector));
                    return elements.some(el => {
                        const content = el.textContent.trim().toLowerCase();
                        return texts.some(t => content === t.toLowerCase() || content.includes(t.toLowerCase()));
                    });
                };

                // Signals for Logged Out
                const isLoggedOut = hasText('button, a', ['Entrar', 'Log in', 'Login']);
                if (isLoggedOut) return false;

                // Signals for Logged In
                const isLoggedIn = hasText('button, a, span', ['Depósito', 'Deposit', 'Carteira', 'Wallet', 'Sair', 'Sign out', 'Desconectar']);
                if (isLoggedIn) return true;

                // Fallback to server-side state (injected at render time)
                return <?php echo e(auth()->check() ? 'true' : 'false'); ?>;
            };

            const hideSports = () => {
                const listItems = document.querySelectorAll('li');
                listItems.forEach(li => {
                    const text = li.textContent.trim();
                    if (text === 'Esportes' || text === 'Sports') {
                        li.style.setProperty('display', 'none', 'important');
                    }
                });
            };

            hideSports();

            const observer = new MutationObserver(hideSports);
            observer.observe(document.body, { childList: true, subtree: true });

            // Script to update menu items (Affiliate, Sports, Wallet, All Games, etc.)
            const updateMenu = () => {
                const isLogged = checkIsLogged();
                
                // --- Logic for Bottom Menu Buttons ---
                const buttons = document.querySelectorAll('button.inline-flex.flex-col.items-center.justify-center.px-5.group');
                buttons.forEach(btn => {
                    const textSpan = btn.querySelector('span');
                    if (!textSpan) return;
                    
                    const text = textSpan.textContent.trim();
                    const isCustom = btn.classList.contains('custom-register-btn');
                    const isSaque = text === 'Saque';
                    const isCustomSaque = btn.classList.contains('custom-saque-btn');
                    const isCarteira = text === 'Carteira';
                    const isCustomCarteira = btn.classList.contains('custom-carteira-btn');

                    // --- Logic for Affiliate/Register/Home Button ---
                    // Target conditions
                    const isTargetOriginal = !isCustom && (text === 'Afiliado' || text === 'Esportes' || text === 'Sports');
                    const isTargetCustom = isCustom; // Always update custom buttons if state mismatches

                    if (isTargetOriginal || isTargetCustom) {
                        // Determine desired state
                        const targetText = isLogged ? 'Início' : 'Registrar';
                        
                        // If custom and already correct, skip
                        if (isCustom && text === targetText) return;

                        // Create new button (clone or fresh)
                        const newBtn = btn.cloneNode(true);
                        if (!isCustom) newBtn.classList.add('custom-register-btn');
                        
                        // Update Text
                        const span = newBtn.querySelector('span');
                        if (span) span.textContent = targetText;
                        
                        // Update Icon
                        const img = newBtn.querySelector('img');
                        if (img) img.remove();
                        
                        // Remove existing SVG if any (from previous custom state)
                        const oldSvg = newBtn.querySelector('svg');
                        if (oldSvg) oldSvg.remove();

                        // Create Icon
                        const svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
                        svg.setAttribute("viewBox", "0 0 24 24");
                        svg.setAttribute("width", "25");
                        svg.setAttribute("height", "25");
                        svg.setAttribute("fill", "none");
                        svg.setAttribute("stroke", "currentColor");
                        svg.setAttribute("stroke-width", "2");

                        if (isLogged) {
                            // Home Icon
                            svg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />';
                            
                            // Click: Go to Home
                            newBtn.onclick = (e) => {
                                e.preventDefault();
                                e.stopPropagation(); // Stop Vue events
                                window.location.href = '/';
                            };
                        } else {
                            // Register Icon
                            svg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />';
                            
                            // Click: Open Register
                            newBtn.onclick = (e) => {
                                e.preventDefault();
                                e.stopPropagation();
                                
                                const allButtons = Array.from(document.querySelectorAll('button, a'));
                                const headerRegisterBtn = allButtons.find(el => {
                                    const t = el.textContent.trim().toLowerCase();
                                    return (t === 'registrar' || t === 'cadastrar' || t === 'register') && el !== newBtn;
                                });

                                if (headerRegisterBtn) {
                                    headerRegisterBtn.click();
                                } else {
                                    window.location.href = '/register';
                                }
                            };
                        }
                        
                        newBtn.prepend(svg);
                        
                        // Replace in DOM
                        btn.parentNode.replaceChild(newBtn, btn);
                        return; // Done with this button
                    }

                    // --- Logic for "Saque" Button Redirect ---
                    if ((isSaque || isCustomSaque) && !btn.hasAttribute('data-saque-fixed')) {
                        const newBtn = btn.cloneNode(true);
                        newBtn.setAttribute('data-saque-fixed', 'true');
                        newBtn.classList.add('custom-saque-btn');

                        // Keep original content (icon/text) but override click
                        newBtn.onclick = (e) => {
                            e.preventDefault();
                            e.stopPropagation();
                            window.location.href = '/profile/wallet';
                        };

                        btn.parentNode.replaceChild(newBtn, btn);
                        return;
                    }

                    // --- Logic for "Carteira" -> "Depósito" Rename and Redirect ---
                    if ((isCarteira || isCustomCarteira) && !btn.hasAttribute('data-carteira-fixed')) {
                        const newBtn = btn.cloneNode(true);
                        newBtn.setAttribute('data-carteira-fixed', 'true');
                        newBtn.classList.add('custom-carteira-btn');

                        const span = newBtn.querySelector('span');
                        if (span) span.textContent = 'Depósito';

                        // Click: Go to Deposit
                        newBtn.onclick = (e) => {
                            e.preventDefault();
                            e.stopPropagation();
                            window.location.href = '/profile/deposit';
                        };

                        btn.parentNode.replaceChild(newBtn, btn);
                        return;
                    }
                });

                // --- Logic for "All games" -> "Todos os Jogos" Rename (Sidebar) ---
                const allGamesLinks = document.querySelectorAll('a[href*="/casino/provider/all/category/all-games"]');
                allGamesLinks.forEach(link => {
                    // Check if text is "All games"
                    const span = link.querySelector('span');
                    if (span && span.textContent.trim() === 'All games' && !link.hasAttribute('data-all-games-fixed')) {
                        const newLink = link.cloneNode(true);
                        newLink.setAttribute('data-all-games-fixed', 'true');
                        
                        const newSpan = newLink.querySelector('span');
                        if (newSpan) newSpan.textContent = 'Todos os Jogos';
                        
                        link.parentNode.replaceChild(newLink, link);
                    }
                });
            };

            // Run initially and observe
            updateMenu();
            const registerObserver = new MutationObserver(updateMenu);
            registerObserver.observe(document.body, { childList: true, subtree: true });
        });
    </script>
</body>

</html><?php /**PATH C:\xampp\htdocs\resources\views/layouts/app.blade.php ENDPATH**/ ?>