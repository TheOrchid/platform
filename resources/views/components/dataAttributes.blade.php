@if(isset($dataAttributes))@foreach($dataAttributes as $dataAttributeField => $dataAttributeValue)data-{{$dataAttributeField}}="{{$dataAttributeValue}}"@endforeach @endif