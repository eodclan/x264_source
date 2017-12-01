function klappe(id)
{
  var klappText = document.getElementById('k' + id);
  var klappBild = document.getElementById('pic' + id);

  if (klappText.style.display == 'none')
  {
    klappText.style.display = 'block';
    // klappBild.src = 'pic/blank.gif';
  }
  else
  {
    klappText.style.display = 'none';
    // klappBild.src = 'pic/blank.gif';
  }
}

function klappe_news(id)
{
  var klappText = document.getElementById('k' + id);
  var klappBild = document.getElementById('pic' + id);

  if (klappText.style.display == 'none')
  {
    klappText.style.display = 'block';
    klappBild.src = 'pic/minus.gif';
  }
  else
  {
    klappText.style.display = 'none';
    klappBild.src = 'pic/plus.gif';
  }
}

function klappe_nfo(id)
{
  var klappText = document.getElementById('k' + id);
  var klappBild = document.getElementById('pic' + id);

  if (klappText.style.display == 'none')
  {
    klappText.style.display = 'block';
    klappBild.src = 'pic/verb.png';
  }
  else
  {
    klappText.style.display = 'none';
    klappBild.src = 'pic/zeig.png';
  }
}

function expandCollapse(Id)
{
  var plusMinusImg = document.getElementById("plusminus" + Id);
  var detailRow    = document.getElementById("details" + Id);

  if (detailRow.style.display == "none")
  {
    plusMinusImg.src        = "../../pic/minus.gif";
    detailRow.style.display = "block";
  }
  else
  {
    plusMinusImg.src        = "../../pic/plus.gif";
    detailRow.style.display = "none";
  }
}