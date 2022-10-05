<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
CJSCore::Init(array('ajax'));
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
  <?=GetMessage('ADD_EVENT_MSG_BTN')?>
</button>
<div class="calendar-wrapper">
  <button id="btnPrev" type="button"><?=GetMessage('PREV')?></button>
  <button id="btnNext" type="button"><?=GetMessage('NEXT')?></button>
  <div id="divCal"></div>
</div>
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><?=GetMessage('ADD_EVENT_MODAL')?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label"><?=GetMessage('DATE')?></label>
            <div class="col-sm-10">
              <input id="eventDate" type="date" class="form-control-plaintext" id="staticEmail">
            </div>
          </div>
          <div class="form-group row">
            <label for="inputPassword" class="col-sm-2 col-form-label"><?=GetMessage('DESCRIPTION')?></label>
            <div class="col-sm-10">
              <input id="eventText" type="test" class="form-control" id="inputPassword">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=GetMessage('CLOSE')?></button>
        <button id='sendRequest' type="button" class="btn btn-primary"><?=GetMessage('ADD')?></button>
      </div>
    </div>
  </div>
</div>
<script>
  window.onload = function() {
    const calendar = new Cal({
      events: <?= \Bitrix\Main\Web\Json::encode($arResult['EVENTS']) ?>,
      nodeId: "divCal"
    });
    calendar.init();
  }
</script>