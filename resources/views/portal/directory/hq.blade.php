<?php
$l10n = $locale = App::getLocale();
$title = "title_" . $locale;
$subtitle = "subtitle_" . $locale;
$content = "content_" . $locale;
?>
@extends('layouts.portal.app-v3-page')

@push('css')
    <style>
        .content {
            margin-top: 30px;
            margin-bottom: 20px;
        }

        .content-overlay {
            margin-top: -160px;
            margin-bottom: 120px;
            text-shadow: 2px 2px 4px #000000;
            color: #FFFFFF;
        }

        .content-overlay h1 {
            font-weight: 700;
        }

        th {
            background-color: #0F4EA3;
        }

    </style>
@endpush

@section('content')
    <div class="content container" style="margin-top: 80px">
        <div class="row">
            <div class="col-md-12">

                <h2>{!! $page->$title !!}</h2>

                @if($locale == 'en')
                    <p style="text-transform: uppercase;">
                        {{ $hq->branch_address_en}}<br>
                        {{ $hq->branch_address3_en}}<br>
                        {{ $hq->branch_postcode}}
                        {{ $hq->district->district}}
                        {{ $hq->state->state}}<br>
                        {{ trans('new.main_line')}} : {{ $hq->branch_office_phone}}<br>
                        {{ trans('master.directory_branch_faks') }} : {{ $hq->branch_office_fax}}<br>
                        {{ trans('new.tol_line')}} : 1-800-88-9811<br></p>
                @endif

                @if($locale == 'my')
                    <p style="text-transform: uppercase;">
                        {{ $hq->branch_address}}<br>
                        {{ $hq->branch_address3}}<br>
                        {{ $hq->branch_postcode}}
                        {{ $hq->district->district}}
                        {{ $hq->state->state}}<br>
                        {{ trans('new.main_line')}} : {{ $hq->branch_office_phone}}<br>
                        {{ trans('master.directory_branch_faks') }} : {{ $hq->branch_office_fax}}<br>
                        {{ trans('new.tol_line')}} : 1-800-88-9811<br></p>
                @endif

                <table class="table table-bordered table-striped" style="width: 100%;" cellpadding="5">
                    @foreach($directoryHQDivision->getDivisions() as $division)
                        <tbody>
                        <tr>
                            <th colspan="4" style="text-transform:uppercase;">{{ $division }}</th>
                        </tr>
                        <tr style="background-color:#40C6D2;">
                            <td>{!! trans('master.directory_hq_name') !!}</td>
                            <td>{!! trans('master.directory_hq_designation') !!}</td>
                            <td>{{ trans('master.directory_hq_ext') }}</td>
                            <td>{{ trans('master.directory_hq_email') }}</td>
                        </tr>
                        @foreach($directoryHQ as $directory)
                            @if($directory->directory_hq_division == $division)
                                <tr>
                                    <td>{{$directory->directory_hq_name}}</td>
                                    <td>{{$directory->directory_hq_designation}}</td>
                                    <td>{{$directory->directory_hq_ext}}</td>
                                    <td>{{$directory->directory_hq_email}}</td>
                                </tr>
                            @endif
                        @endforeach
                        @endforeach
                        </tbody>
                </table>
                <br>
                <table class="table table-bordered table-striped" style="width: 100%;" cellpadding="5">
                    <tr>
                        <th width="250">{{ trans('master.directory_branch_state') }}</th>
                        <th>{{ trans('new.tel') }}</th>
                    </tr>
                    @foreach ($directoryBranch as $branch)
                        <tr>
                            <td style="text-transform: uppercase;">{{$branch->state->state}}</td>
                            <td style="text-transform: uppercase;"> {{$branch->directory_branch_tel}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection