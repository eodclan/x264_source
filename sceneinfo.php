<?php
require_once(dirname(__FILE__) . "/include/bittorrent.php");

dbconn(false);
x264_header("Scene Begriffe");
loggedinorreturn();

print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i> Scene Begriffe
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
                    <form class='form-horizontal'>
                        <div class='form-group'>
                            <label class='form-control-label' for='prependedInput'>Cam-Rip (CAM):</label>
                            <div class='controls'>
                                <div class='input-prepend input-group'>Die schlechteste aller Aufzeichnungsformen.   Der Film wurde mit einem Camcorder im Kino von der Leinwand abgefilmt. Die   Bildqualit&auml;t ist meist akzeptabel bis gut, bei manchen Filmen sind in kurzen   Momenten K&ouml;pfe von anderen Kinobesuchern im Bild. Die Tonqualit&auml;t ist sehr   unterschiedlich, St&ouml;rger&auml;usche wie Gel&auml;chter des Publikums sind m&ouml;glich.                                </div>
                            </div>
                        </div>
                    <form class='form-horizontal'>
                        <div class='form-group'>
                            <label class='form-control-label' for='prependedInput'>Telesync (TS):</label>
                            <div class='controls'>
                                <div class='input-prepend input-group'>Diese Ripps werden mit   einer auf einem Stativ befestigten professionellen (Digital)Kamera in einem   leeren Kino von der Leinwand abgefilmt. Die Bildqualit&auml;t ist wesentlich besser   als bei einer Cam. Der Ton wird bei diesen Produktionen oft direkt vom Projektor   oder einer anderen externen Quelle abgenommen, ist somit st&ouml;rungsfrei und in der   Regel sogar Stereo.                                 </div>
                            </div>
                        </div>
                    <form class='form-horizontal'>
                        <div class='form-group'>
                            <label class='form-control-label' for='prependedInput'>Screener (SCR):</label>
                            <div class='controls'>
                                <div class='input-prepend input-group'>Die zweitbeste aller   Aufzeichnungsformen. Hier wird als Basis eine Pressekopie von einem   professionellen Videoband des Filmes benutzt. Die Bildqualit&auml;t ist mit sehr   gutem VHS vergleichbar. Der Ton ist ebenso einwandfrei, Stereo und oft Dolby   Surround.                                 </div>
                            </div>
                        </div>
                    <form class='form-horizontal'>
                        <div class='form-group'>
                            <label class='form-control-label' for='prependedInput'>Workprint (WP):</label>
                            <div class='controls'>
                                <div class='input-prepend input-group'>Ein besonderes Bonbon   f&uuml;r Filmfans. Diese Ver&ouml;ffentlichung ist sozusagen eine &quot;Betaversion&quot; eines   Films. Ihre Ver&ouml;ffentlichung auf VCD ist meist weit vor dem weltweiten   Kinostart. Es ist eine Vorabversion des Films, daher ist qualitativ von   exzellent bis fast unanschaubar alles m&ouml;glich, je nach Quellmaterial. Oft fehlen   allerdings noch einige Szenen, oder die Schnitte sind unschl&uuml;ssig. Positiv ist,   dass manchmal Szenen enthalten sind, die im Endprodukt dem Schneidetisch zum   Opfer fallen. Bei einigen dieser Produktionen ist am unteren oder oberen   Bildrand ein laufender Z&auml;hler - ein sogenannter Timecode - der zum Schneiden des   Filmmaterials ben&ouml;tigt wird, eingeblendet.                                 </div>
                            </div>
                        </div>
                    <form class='form-horizontal'>
                        <div class='form-group'>
                            <label class='form-control-label' for='prependedInput'>Telecine (TC):</label>
                            <div class='controls'>
                                <div class='input-prepend input-group'>Diese Ripps sind sehr   selten, bieten daf&uuml;r aber mit Abstand die beste Qualit&auml;t. Die Quelle ist ein   Filmprojektor mit Audio / Video Ausgang; das Filmmaterial wird hier direkt vom   Projektor abgenommen. Bild- und Tonqualit&auml;t sind exzellent.                                 </div>
                            </div>
                        </div>
                    <form class='form-horizontal'>
                        <div class='form-group'>
                            <label class='form-control-label' for='prependedInput'>DVD- oder LD-Rip:</label>
                            <div class='controls'>
                                <div class='input-prepend input-group'>Hier wurde eine offizielle DVD oder eine Laserdisk als Quelle f&uuml;r den Ripp benutzt. Qualitativ   sind diese Versionen exzellent, allerdings sind sie bei neuen Filmen selten zu   finden, da die offiziellen DVD oder Laserdisks erst einige Zeit nach Kinostart   in den USA auf den Markt kommt. Trotzdem kann die Ver&ouml;ffentlichung vor dem   Kinostart in Deutschland liegen, da viele Filme hierzulande mit ca. einem halben   Jahr Verz&ouml;gerung anlaufen.                                </div>
                            </div>
                        </div>
                    <form class='form-horizontal'>
                        <div class='form-group'>
                            <label class='form-control-label' for='prependedInput'>BAD AR:</label>
                            <div class='controls'>
                                <div class='input-prepend input-group'>Die Aspect Ratio des Ripps ist nicht korrekt.   (z.B. Eierk&ouml;pfe)                                 </div>
                            </div>
                        </div>
                    <form class='form-horizontal'>
                        <div class='form-group'>
                            <label class='form-control-label' for='prependedInput'>BAD FPS:</label>
                            <div class='controls'>
                                <div class='input-prepend input-group'>Ein solches Release folgt nicht dem Szene-Standart aufgrund unzureichender/schlechter Framerate. (~24fps)                                 </div>
                            </div>
                        </div>
                    <form class='form-horizontal'>
                        <div class='form-group'>
                            <label class='form-control-label' for='prependedInput'>BAD IVTC:</label>
                            <div class='controls'>
                                <div class='input-prepend input-group'>Als IVTC (inverse telecine)   bezeichnet man den Prozess des heruntekonvertierens eines Movies mit 30fps auf eine Framerate von 24fps um Platz zu sparen. Das Bild erscheint dem geschulten   Auge dadurch unsauber, &quot;holprig&quot;.                                 </div>
                            </div>
                        </div>
                    <form class='form-horizontal'>
                        <div class='form-group'>
                            <label class='form-control-label' for='prependedInput'>DC:</label>
                            <div class='controls'>
                                <div class='input-prepend input-group'>Ein Film mit speziellen Szenen, die   in der Urver&ouml;ffentlichung nicht zu sehen waren. Bei vielen Filmen hat nicht der   Regisseur das letzte Wort, sondern die Produzenten bestimmen, in welcher   Schnittfassung ein Film in unsere Kinos kommt. Ein Regisseur, der mit der   Kinoversion seines Films nicht einverstanden war, hat vielleicht sp&auml;ter die   Gelegenheit, eine Schnittfassung zu erstellen, die seinen Vorstellungen   entspricht. Diese Fassung nennt man &quot;Director's Cut&quot;.                                 </div>
                            </div>
                        </div>
                    <form class='form-horizontal'>
                        <div class='form-group'>
                            <label class='form-control-label' for='prependedInput'>DUBBED:</label>
                            <div class='controls'>
                                <div class='input-prepend input-group'>Originalton ist ersetzt worden   (z.B. Ton aus einem deutschen Kino genommen und mit nem englischen Release gemixt) Mic.Dubbed = z.B.: engl. Release mit deutscher Tonspur versehen, die per   Micro im Kino aufgenommen wurde Line.Dubbed = z.B.: engl. Release mit deutscher   Tonspur versehen, die &uuml;ber den &quot;Line&quot;-Ausgang von einer externen Quelle im Kino   aufgenommen wurde.                                 </div>
                            </div>
                        </div>
                    <form class='form-horizontal'>
                        <div class='form-group'>
                            <label class='form-control-label' for='prependedInput'>DUPE:</label>
                            <div class='controls'>
                                <div class='input-prepend input-group'>Zweiter, sp&auml;terer Release eines   Titels einer anderen Releasegroup das keinen nennenswerten Qualit&auml;tsunterschied  bietet.</div> </div>
                    <form class='form-horizontal'>
                        <div class='form-group'>
                            <label class='form-control-label' for='prependedInput'>FS:</label>
                            <div class='controls'>
                                <div class='input-prepend input-group'>Das Release ist Fullscreen, also   Vollbild. Dabei wird die gesamte sichtbare Bildfl&auml;che<br />ausgenutzt und somit schwarze R&auml;nder vermieden.                                </div>
                            </div>
                        </div>
                    <form class='form-horizontal'>
                        <div class='form-group'>
                            <label class='form-control-label' for='prependedInput'>INTERLACED:</label>
                            <div class='controls'>
                                <div class='input-prepend input-group'>Das Bild hat waagerechten   Bildversetzungen die aber meist nur bei genauem hinsehen auffallen.                                 </div>
                            </div>
                        </div>
                    <form class='form-horizontal'>
                        <div class='form-group'>
                            <label class='form-control-label' for='prependedInput'>INTERNAL:</label>
                            <div class='controls'>
                                <div class='input-prepend input-group'>Ein Release, das bereits von   einer anderen Crew ver&ouml;ffentlicht wurde oder den allgemeinen Regeln nicht   gerecht werden kann (vgl. NUKE) und aus diesem Grund nicht &ouml;ffentlich sondern   lediglich Crew-intern released wird.                                 </div>
                            </div>
                        </div>
                    <form class='form-horizontal'>
                        <div class='form-group'>
                            <label class='form-control-label' for='prependedInput'>LETTERBOX:</label>
                            <div class='controls'>
                                <div class='input-prepend input-group'>Letterbox ist ein anderer   Begriff f&uuml;r Widescreen (siehe WS).                                 </div>
                            </div>
                        </div>
                    <form class='form-horizontal'>
                        <div class='form-group'>
                            <label class='form-control-label' for='prependedInput'>LIMITED:</label>
                            <div class='controls'>
                                <div class='input-prepend input-group'>Der Film l&auml;uft/lief in weniger   als 500 Kinos.                                 </div>
                            </div>
                        </div>
                    <form class='form-horizontal'>
                        <div class='form-group'>
                            <label class='form-control-label' for='prependedInput'>NUKE:</label>
                            <div class='controls'>
                                <div class='input-prepend input-group'>Es gibt zwei arten des &quot;nukings&quot;:   Zum einen wird ein release von einer einzelnen Release-News-Seite genuked, weil es nicht ihren &quot;Regeln&quot; eines Ripps entspricht, zum anderen gibt es allgemeine   nukes (von der gesamten Szene), wenn das Release DUPE, also doppelt released   wurde, oder anderweitig irregul&auml;r ist.                                 </div>
                            </div>
                        </div>
                    <form class='form-horizontal'>
                        <div class='form-group'>
                            <label class='form-control-label' for='prependedInput'>PD:</label>
                            <div class='controls'>
                                <div class='input-prepend input-group'>Dieses Release setzt sich bspw. aus   einer &quot;extern&quot; bezogenen Bildquelle (z.B. von einer amerikanischen Releasegroup) und einer &quot;eigenen&quot; (selbst abgenommenen) deutschen Tonspur zusammen. Das ganze   h&auml;lt sich an sog. Pirate-Dub-Regeln, die exakt definieren, was ein Pirate Dub   befolgen muss. Verst&ouml;sse werden mit NUKE geahndet. Es sei gesagt, dass es sich   hierbei um eine deutsche Regelung handelt, die jedoch nicht von allen deutschen   Dub-Crews akzeptiert wird und somit nicht als Standart betrachtet werden kann.                                 </div>
                            </div>
                        </div>
                    <form class='form-horizontal'>
                        <div class='form-group'>
                            <label class='form-control-label' for='prependedInput'>PROPER:</label>
                            <div class='controls'>
                                <div class='input-prepend input-group'>Ein fr&uuml;heres Release dieses   Filmes war qualitativ minderwertiger als dieses Release.                                </div>
                            </div>
                        </div>
                    <form class='form-horizontal'>
                        <div class='form-group'>
                            <label class='form-control-label' for='prependedInput'>PS:</label>
                            <div class='controls'>
                                <div class='input-prepend input-group'>Pan and Scan: Filme, die f&uuml;r eine   Auswertung im Kino gedreht wurden, haben ein Bildformat, das auf die rechteckige   Kinoleinwand ausgerichtet ist. Wenn ein solcher Film nun f&uuml;r den Gebrauch auf   dem heimischen Fernseher auf Video &uuml;berspielt wird, ist eine Anpassung des   Bildes notwendig, so dass es den viereckigen Fernsehbildschirm ausf&uuml;llt. Die   meisten amerikanischen Filme, die nach 1955 entstanden sind, wurden im   amerikanischen Breitwandformat von 1,85:1 gedreht (f&uuml;r die meisten europ&auml;ischen   Filme gilt das europ&auml;ische Breitwandformat von 1,66:1). Ausgenommen ist das noch   breitere Cinemascope-Format (2,35:1), f&uuml;r das eine anamorphotische Linse   verwendet wird. Das Standard-Bildformat eines Fernsehger&auml;tes betr&auml;gt dagegen   1,33:1. Beim Transfer auf Video wird das Bild also verkleinert. Dies geschieht   dadurch, dass man das komplette Bild abf&auml;hrt (der englische Begriff daf&uuml;r ist   &quot;pan&quot;) und sich dann auf einen Bildausschnitt konzentriert. Die Breite des   Bildes wird verringert, wobei ein Teil verloren geht. Wenn bei einem Video oder   bei einer DVD keine Angaben zum Bildformat vorliegen und der Hinweis   &quot;Originalkinoformat&quot; fehlt, muss man davon ausgehen, dass die Bildgr&ouml;&szlig;e dem   Fernsehformat (1,33:1) durch das Pan and Scan-Verfahren angepasst wurde. Wer   lieber das ganze Bild sehen m&ouml;chte, sollte -- wenn es sie gibt -- auf   Widescreen- bzw. Letterbox-Versionen zur&uuml;ckgreifen. Ein Vollbild-Release (vgl.   FS) ist das Ergebnis aus dem Pan and Scan Verfahren.                                 </div>
                            </div>
                        </div>
                    <form class='form-horizontal'>
                        <div class='form-group'>
                            <label class='form-control-label' for='prependedInput'>RECODE:</label>
                            <div class='controls'>
                                <div class='input-prepend input-group'>Ein Release wurde in ein   anderes Format umkonvertiert (z.B. 3CD SVCD Release --&gt; 1CD DivX Release),   oder neu encodiert.                                 </div>
                            </div>
                        </div>
                    <form class='form-horizontal'>
                        <div class='form-group'>
                            <label class='form-control-label' for='prependedInput'>REPACK:</label>
                            <div class='controls'>
                                <div class='input-prepend input-group'>Beim Packen des Release z.B. zu   einem RAR-Archiv kam es zu Fehlern und das Archiv wies beim entpacken bspw. CRC-Fehler auf und wurde deshalb erneut gepackt und neu released.                                 </div>
                            </div>
                        </div>
                    <form class='form-horizontal'>
                        <div class='form-group'>
                            <label class='form-control-label' for='prependedInput'>RERIP:</label>
                            <div class='controls'>
                                <div class='input-prepend input-group'>Der Film wurde erneut gerippt.                                 </div>
                            </div>
                        </div>
                    <form class='form-horizontal'>
                        <div class='form-group'>
                            <label class='form-control-label' for='prependedInput'>SE:</label>
                            <div class='controls'>
                                <div class='input-prepend input-group'>Ein Video oder eine DVD k&ouml;nnen auch   als Special Edition herausgebracht werden. Eine Special Edition enh&auml;lt Bonusmaterial und/oder zus&auml;tzliche Szenen, die in der Kinoversion oder der normalen Video-/DVD-Fassung nicht zu sehen waren.                                 </div>
                            </div>
                        </div>
                    <form class='form-horizontal'>
                        <div class='form-group'>
                            <label class='form-control-label' for='prependedInput'>STV:</label>
                            <div class='controls'>
                                <div class='input-prepend input-group'>Straight To Video bedeutet, das   der Film von einem Filmprojektor abgenommen und direkt in Echtzeit encodiert wurde. (vgl. Verfahren digitaler Videorecorder)                                </div>
                            </div>
                        </div>
                    <form class='form-horizontal'>
                        <div class='form-group'>
                            <label class='form-control-label' for='prependedInput'>SUBBED:</label>
                            <div class='controls'>
                                <div class='input-prepend input-group'>Dieses Movie besitzt Untertitel. Dies kann von einem einzelnen, kleinen bis zu mehreren oder sehr grossen Untertiteln reichen, die je nach dem sehr viel Platz, i.d.R. am unteren   Bildrand, einnehmen.                                 </div>
                            </div>
                        </div>
                    <form class='form-horizontal'>
                        <div class='form-group'>
                            <label class='form-control-label' for='prependedInput'>WATERMARKED:</label>
                            <div class='controls'>
                                <div class='input-prepend input-group'>Kleine dauerhafte Einblendungen irgendwelcher K&uuml;rzel oder Symbole der Release-Group oder des Verleihers.                                 </div>
                            </div>
                        </div>
                    <form class='form-horizontal'>
                        <div class='form-group'>
                            <label class='form-control-label' for='prependedInput'>WS:</label>
                            <div class='controls'>
                                <div class='input-prepend input-group'>Ein Widescreen-Video versucht das gesamte Bild, so wie es im Kino zu sehen ist, auch auf dem Fernseher zu erhalten   -- obwohl sich die Proportionen der Leinwand und des Fernsehschirms stark voneinander unterscheiden. Eine Widescreen-Version beh&auml;lt die Ausma&szlig;e des Filmbildes bei (in den meisten F&auml;llen 1,85:1), indem ober- und unterhalb des Bildes schwarze Balken hinzugef&uuml;gt werden, die das rechteckige Format der   Kinoleinwand simulieren. Es gibt unterschiedliche Breitwandformate, die diverse   Zwischengr&ouml;&szlig;en verwenden. Die Breite der schwarzen Balken ist daher immer vom   tats&auml;chlichen Bildformat der Kinokopie abh&auml;ngig. Filme, die nicht im Widescreen-   oder Letterbox-Format auf Video kopiert wurden, f&uuml;llen den ganzen Bildschirm aus   und wurden mit dem &quot;Pan and Scan&quot;-Verfahren bearbeitet. Gibt es von einem Film   zwei Versionen auf Video, eine Vollbild- (&quot;Pan and Scan&quot;) und eine   Widescreen-Fassung, dann ist der Inhalt gleich. Die Titel unterscheiden sich nur in der Art, wie sie auf dem Fernsehbildschirm wiedergegeben werden.                                </div>
                            </div>
                        </div>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";

x264_footer();
?>