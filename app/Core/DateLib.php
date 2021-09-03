<?php

namespace App\Core;


use Carbon\Carbon;

class DateLib
{

    public static function getNow(){
        $carbon = Carbon::now()->setTimezone(config('app.timezone'));
        return $carbon;
    }

    public static function getNowWithoutTz(){
        $carbon = Carbon::now();
        return $carbon;
    }

    public static function addTz($date)
    {
        return Carbon::parse($date, config('app.timezone'));
    }

    public static function getDateFromTimeStamp($value)
    {
        return Carbon::createFromTimestamp($value)
            ->timezone(config('app.timezone'))
            ->toDateTimeString();
    }

    public static function getDateTimeString(){
        return self::getNow()->toDateTimeString();
    }

    public static function getDateFromString($date){
        return Carbon::parse($date)
            ->timezone(config('app.timezone'))
            ->toDateString();
    }

    public static function getDateTimeFromStringWithoutTz($date){
        return Carbon::parse($date)
            ->toDateTimeString();
    }

    public static function convertDateFromString($date){
        return Carbon::parse($date)
            ->timezone(config('app.timezone'));
    }

    public static function convertDateStringToTimeStamp($datetime){
        $date = Carbon::parse($datetime)
            ->timezone(config('app.timezone'));

        if (request()->header('Debug')) {
            return $date->toDateTimeString();
        }

        return $date->timestamp;
    }

    public static function convertDateStringToTimeStampWithoutTz($datetime){
        $date = Carbon::parse($datetime, config('app.timezone'));

        if (request()->header('Debug')) {
            return $date->toDateTimeString();
        }

        return $date->timestamp;
    }

    public static function convertDateTimeToString($date, $format = 'Y-m-d H:i:s'){
        return Carbon::parse($date)
            ->timezone(config('app.timezone'))
            ->format($format);
    }

    public static function convertDateTimeToStringWithoutTimezone($date, $format = 'Y-m-d H:i:s'){
        return Carbon::parse($date)
            ->format($format);
    }

    public static function convertDateToString($date){
        return Carbon::parse($date)
            ->timezone(config('app.timezone'))
            ->format('d/m/Y h:i A');
    }

    public static function convertDateToStringWithoutTimezone($date){
        return Carbon::parse($date)
            ->format('d/m/Y h:i A');
    }

    public static function formatDateTime($date, $format = 'Y-m-d H:i:s')
    {
        return Carbon::parse($date)
            ->timezone(config('app.timezone'))
            ->format($format);
    }


    public static function formatDateTimeWithoutTimezone($date, $format = 'Y-m-d H:i:s')
    {
        return Carbon::parse($date, config('app.timezone'))
            ->format($format);
    }

    public static function addMinute($num){
        return self::getNow()->addMinutes($num)->toDateTimeString();
    }

    public static function addMonths($num){
        return self::getNow()->addMonths($num)->toDateTimeString();
    }

    public static function addHours($num){
        return self::getNow()->addHours($num)->toDateTimeString();
    }

    public static function addDays($num){
        return self::getNow()->addDays($num)->toDateTimeString();
    }

    public static function getSecondFromTimeStamp($value)
    {
        $start =  Carbon::createFromTimestampMsUTC($value)
            ->timezone(config('app.timezone'));
        return $start->diffInSeconds(self::getNow());
    }

    public static function getBeginOfToday(){
        return DateLib::getNow()->modify('today');
    }

    public static function getEndOfToday(){
        return DateLib::getNow()->modify('tomorrow');
    }
}
