<?php
$locale = App::getLocale();
$title = "title_".$locale;
$subtitle = "subtitle_".$locale;
$content = "content_".$locale;
?>
@extends('layouts.portal.app')

@section('title')
{!! $page->$title !!}
@endsection

@section('subtitle')
{!! $page->$subtitle !!}
@endsection

@section('content')
{!! $page->$content !!}
@endsection