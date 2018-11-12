<footer>
    <sup>&copy;</sup> 2018 - XtremeWebframework2
    <nav id="footer_navigation">
        <?=
        Html::ul(array(
            Html::link('impressum.html', 'Impressum'),
            Html::link('datenschutz.html', 'Datenschutz'),
            '<a style="cursor:pointer" onclick="window.gx.startup(true)">Datenschutzeinstellungen</a>',
        ))
        ?>
    </nav>
</footer>