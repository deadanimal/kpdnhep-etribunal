<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">{{$name}}</h4>
</div>
<div style="max-height: 100%">
<center>
<div>
<img style="max-height: 50%;max-width: 50%;" src="{{$url or ''}}"></img><br><br>
<a style="margin-top: 5px" href="{{$url or ''}}"  download="{{$name}}"><button type='button' class='btn btn-xs btn-info' style='margin-bottom: 10px'><i class='fa fa-download'></i>Download</button></a></div>
</center>
</div>