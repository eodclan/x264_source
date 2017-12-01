function send_reseed(torrentid)
{
  var ajax = new tbdev_ajax();
  var varsString = "";

  ajax.onShow ('');
  ajax.requestFile = "ajax_treseed.php";
  ajax.setVar("reseedid", torrentid);
  ajax.setVar("ajax", "yes");

  ajax.method = 'POST';
  ajax.element = 'reseed';

  ajax.sendAJAX(varsString);
}