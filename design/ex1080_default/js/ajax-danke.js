function send(torrentid)
{
  var ajax = new tbdev_ajax();
  var varsString = "";

  ajax.onShow ('');
  ajax.requestFile = "ajax_thanks.php";
  ajax.setVar("torrentid", torrentid);
  ajax.setVar("ajax", "yes");

  ajax.method = 'POST';
  ajax.element = 'ajax';

  ajax.sendAJAX(varsString);
}