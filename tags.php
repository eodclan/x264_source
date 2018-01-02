<?php
// ************************************************************************************//
// * D€ Source 2018
// ************************************************************************************//
// * Author: D@rk-€vil™
// ************************************************************************************//
// * Version: 2.0
// * 
// * Copyright (c) 2017 - 2018 D@rk-€vil™. All rights reserved.
// ************************************************************************************//
// * License Typ: Creative Commons licenses
// ************************************************************************************// 
require_once(dirname(__FILE__) . "/include/engine.php");
dbconn();
loggedinorreturn();

x264_header('BBCode-Erklärung');
?>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i> BBCode-Erklärung
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>

	<div class="tag_wrap">
		<h2>Fett</h2>
		<div class="tag_b">Macht den Text innerhalb der Klammern fett</div>
		<div class="tag_a">[b]Text[/b]</div>
		<div class="tag_b">[b]Dies ist fettgedruckter Text.[/b]</div>
		<div class="tag_b"><?=format_comment('[b]Dies ist fettgedruckter Text.[/b]');?></div>
	</div>
	
	<div class="tag_wrap">
		<h2>Kursiv</h2>
		<div class="tag_b">Macht den eingeschlossenen Text kursiv.</div>
		<div class="tag_a">[i]Text[/i]</div>
		<div class="tag_b">[i]Das ist kursiver Text.[/i]</div>
		<div class="tag_b"><?=format_comment('[i]Das ist kursiver Text.[/i]');?></div>
	</div>
	
	<div class="tag_wrap">
		<h2>Unterstreichen</h2>
		<div class="tag_b">Unterstreicht den Text innerhalb der Klammern.</div>
		<div class="tag_a">[u]Text[/u]</div>
		<div class="tag_b">[u]Dieser Text ist unterstrichen.[/u]</div>
		<div class="tag_b"><?=format_comment('[u]Dieser Text ist unterstrichen.[/u]');?></div>
	</div>
	
	<div class="tag_wrap">
		<h2>Farbe (Möglichkeit 1)</h2>
		<div class="tag_b">Ändert die Farbe des eingeschlossenen Textes.</div>
		<div class="tag_a">[color=Farbe]Text[/color]</div>
		<div class="tag_b">[color=red]Dieser Text ist rot.[/color]</div>
		<div class="tag_b"><?=format_comment('[color=red]Dieser Text ist rot.[/color]');?></div>
	</div>
	
	<div class="tag_wrap">
		<h2>Farbe (Möglichkeit 2)</h2>
		<div class="tag_b">Ändert die Farbe des eingeschlossenen Textes.</div>
		<div class="tag_a">[color=RGB]Text[/color]</div>
		<div class="tag_b">[color=#ff0000]Dieser Text ist rot.[/color]</div>
		<div class="tag_b"><?=format_comment('[color=#ff0000]Dieser Text ist rot.[/color]');?></div>
	</div>
	
	<div class="tag_wrap">
		<h2>Größe (bitte nur 11 bis 18 verwenden)</h2>
		<div class="tag_b">Bestimmt die Größe des angezeigten Textes.</div>
		<div class="tag_a">[size=X]text[/size]</div>
		<div class="tag_b">[size=15]Dies ist Größe 15.[/size]</div>
		<div class="tag_b"><?=format_comment('[size=15]Dies ist Größe 15.[/size]');?></div>
	</div>
	
	<div class="tag_wrap">
		<h2>Schriftart</h2>
		<div class="tag_b">Setzt die Schriftart des eingeschlossenen Textes.</div>
		<div class="tag_a">[font=Schriftart]Text[/font]</div>
		<div class="tag_b">[font=Impact]Hallo Welt![/font]</div>
		<div class="tag_b"><?=format_comment('[font=Impact]Hallo Welt![/font]');?></div>
	</div>
	
	<div class="tag_wrap">
		<h2>Zentriert</h2>
		<div class="tag_b">Zeigt den Text zentriert an.</div>
		<div class="tag_a">[center]Text[/center]</div>
		<div class="tag_b">[center]Zentrierter Text[/center]</div>
		<div class="tag_b"><?=format_comment('[center]Zentrierter Text[/center]');?></div>
	</div>
	
	<div class="tag_wrap">
		<h2>Hyperlink (Möglichkeit 1)</h2>
		<div class="tag_b">Setzt einen Link auf eine andere Website.</div>
		<div class="tag_a">[url]URL[/url]</div>
		<div class="tag_b">[url]http://www.example.com/[/url]</div>
		<div class="tag_b"><?=format_comment('[url]http://www.example.com/[/url]');?></div>
	</div>
	
	<div class="tag_wrap">
		<h2>Hyperlink (Möglichkeit 2)</h2>
		<div class="tag_b">Setzt einen Link auf eine andere Website.</div>
		<div class="tag_a">[url=URL]Link Text[/url]</div>
		<div class="tag_b">[url=http://www.example.com/]Beispiellink[/url]</div>
		<div class="tag_b"><?=format_comment('[url=http://www.example.com/]Beispiellink[/url]');?></div>
	</div>
	
	<div class="tag_wrap">
		<h2>Bild</h2>
		<div class="tag_b">Fügt eine Grafik ein.</div>
		<div class="tag_a">[img]URL[/img]</div>
		<div class="tag_b">[img]http://www.example.com/beispiel.gif[/img]</div>
		<div class="tag_b"> --- </div>
	</div>
	
	<div class="tag_wrap" style="height:180px;">
		<h2>Zitat</h2>
		<div class="tag_b">Fügt ein Zitat ein.</div>
		<div class="tag_a">[quote]Zitierter Text[/quote]</div>
		<div class="tag_b">[quote]Ein Widerstand um jeden Preis ist das Sinnloseste, was es geben kann.[/quote]</div>
		<div class="tag_b"><?=format_comment('[quote]Ein Widerstand um jeden Preis ist das Sinnloseste, was es geben kann.[/quote]');?></div>
	</div>

                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
	
<?x264_footer();?>