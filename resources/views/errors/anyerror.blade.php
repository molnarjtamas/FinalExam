@extends('errors.illustrated-layout')

@section('title', 'Unexpected error.')
@section('code', $code ? $code : 'Unknown error.')
@section('message', $message)
