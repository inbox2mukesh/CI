<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Rajan Bansal
 *
 * */
trait timezoneTrait {
    /**
     * Get date and time with country utc
     */
    public function auto_getDatetimeByCountryTimezoneUTC(array $params) {
        $timeZoneId     = '';
        $timeZoneUTC    = '';
        $toDateTime     = '';
        $countryData    = $params["country_data"];
        $timeZonetype   = $params["timezone_type"];

        if($timeZonetype == TIMEZONE_TYPES[0]) {
            $timeZoneId     = $params["timezone_id"];
            $timeZoneUTC    = $params["timezone_utc"];
        }
        
        $date           = $params["date"];
        $time           = $params["time"];
        $dateTime       = $date." ".$time; //From dateTime

        if(isset($params["to_date"]) && !empty($params["to_date"])) {
            $toDateTime       = $params["to_date"]." ".$params["time"]; //To dateTime
        }
        
        if($countryData) {
            $number = 0;
            foreach($countryData as $countryObj) {
                $countryTimeZoneUTCArray[$number] = $this->Timezone_model->get_timezone_utc_by_country_id($countryObj["country_id"]);
                if(!$countryTimeZoneUTCArray[$number]) {
                    $countryTimeZoneUTCArray[$number] = $this->Timezone_model->get_timezone_utc_by_country_id(INDIA_ID);
                    if($countryTimeZoneUTCArray[$number]) {
                        foreach($countryTimeZoneUTCArray[$number] as $key=>$countryTZUTCArray) {

                            if($timeZonetype == TIMEZONE_TYPES[1]) {
                                $timeZoneArray = $this->Timezone_model->get_timezone_by_timezone_id($countryTZUTCArray["timezone_id"]);

                                if(isset($timeZoneArray["utc"]) && $timeZoneArray["utc"]) {
                                    $timeZoneUTC = $timeZoneArray["utc"];
                                }
                                else {
                                    $timeZoneUTC = TIMEZONE_INDIA_UTC;
                                }
                            }
            
                            if(strstr($timeZoneUTC,"+")) {
                                $utcTimezone = str_replace("+","-",$timeZoneUTC);
                            }
                            elseif(strstr($timeZoneUTC,"-")) {
                                $utcTimezone = str_replace("-","+",$timeZoneUTC);
                            }

                            $date_utc       = new \DateTime($dateTime);
                            $date_utc->setTimeZone(new DateTimeZone($utcTimezone));
                            $dateTimeUTC       = $date_utc->format("Y-m-d h:i A"); //From $dateTimeUTC

                            if($toDateTime) {
                                $to_date_utc       = new \DateTime($toDateTime);
                                $to_date_utc->setTimeZone(new DateTimeZone($utcTimezone));
                                $toDateTimeUTC       = $to_date_utc->format("Y-m-d h:i A"); //To $toDateTimeUTC

                                $to_date_utc = new \DateTime($toDateTimeUTC);
                            
                                if($timeZonetype == TIMEZONE_TYPES[0]) {
                                    $to_date_utc->setTimeZone(new DateTimeZone($countryTimeZoneUTCArray[$number][$key]["utc"]));
                                }
                                else {
                                    $to_date_utc->setTimeZone(new DateTimeZone(TIMEZONE_INDIA_UTC));
                                }
                                $countryTimeZoneUTCArray[$number][$key]["to_country_time"] = $to_date_utc->format("d-M-Y h:i A");
                            }

                            $countryTimeZoneUTCArray[$number][$key]["country_id"]              = $countryObj["country_id"];
                            $countryTimeZoneUTCArray[$number][$key]["country_name"]            = $countryObj["country_name"];
                            $countryTimeZoneUTCArray[$number][$key]["default_country_id"]      = INDIA_ID;
                            $countryTimeZoneUTCArray[$number][$key]["default_country_name"]    = "India";
                            $countryTimeZoneUTCArray[$number][$key]["country_timezone_found"]  = 0; //If country id will not found in timezone_masters table then country_timezone_found will be set 0 and default India timzone will be use;

                            $date_utc = new \DateTime($dateTimeUTC);
                            
                            if($timeZonetype == TIMEZONE_TYPES[0]) {
                                $date_utc->setTimeZone(new DateTimeZone($countryTimeZoneUTCArray[$number][$key]["utc"]));
                            }
                            else {
                                $date_utc->setTimeZone(new DateTimeZone(TIMEZONE_INDIA_UTC));
                            }
                            $countryTimeZoneUTCArray[$number][$key]["country_time"] = $date_utc->format("d-M-Y h:i A");
                        }
                    }
                }
                else {
                    foreach($countryTimeZoneUTCArray[$number] as $key=>$countryTZUTCArray) {
                        if($timeZonetype == TIMEZONE_TYPES[1]) {
                            $timeZoneArray = $this->Timezone_model->get_timezone_by_timezone_id($countryTZUTCArray["timezone_id"]);

                            if(isset($timeZoneArray["utc"]) && $timeZoneArray["utc"]) {
                                $timeZoneUTC = $timeZoneArray["utc"];
                            }
                            else {
                                $timeZoneUTC = TIMEZONE_INDIA_UTC;
                            }
                        }
        
                        if(strstr($timeZoneUTC,"+")) {
                            $utcTimezone = str_replace("+","-",$timeZoneUTC);
                        }
                        elseif(strstr($timeZoneUTC,"-")) {
                            $utcTimezone = str_replace("-","+",$timeZoneUTC);
                        }
                        
                        $date_utc       = new \DateTime($dateTime);
                        $date_utc->setTimeZone(new DateTimeZone($utcTimezone));
                        $dateTimeUTC       = $date_utc->format("Y-m-d h:i A");

                        if($toDateTime) {
                            $to_date_utc       = new \DateTime($toDateTime);
                            $to_date_utc->setTimeZone(new DateTimeZone($utcTimezone));
                            $toDateTimeUTC       = $to_date_utc->format("Y-m-d h:i A"); //To $toDateTimeUTC

                            $to_date_utc = new \DateTime($toDateTimeUTC);

                            if($timeZonetype == TIMEZONE_TYPES[0]) {
                                $to_date_utc->setTimeZone(new DateTimeZone($countryTimeZoneUTCArray[$number][$key]["utc"]));
                            }
                            else {
                                $to_date_utc->setTimeZone(new DateTimeZone(TIMEZONE_INDIA_UTC));
                            }
                            $countryTimeZoneUTCArray[$number][$key]["to_country_time"] = $to_date_utc->format("d-M-Y h:i A");
                        }

                        $countryTimeZoneUTCArray[$number][$key]["country_timezone_found"] = 1;
                        
                        $date_utc = new \DateTime($dateTimeUTC);

                        if($timeZonetype == TIMEZONE_TYPES[0]) {
                            $date_utc->setTimeZone(new DateTimeZone($countryTimeZoneUTCArray[$number][$key]["utc"]));
                        }
                        else {
                            $date_utc->setTimeZone(new DateTimeZone(TIMEZONE_INDIA_UTC));
                        }
                        $countryTimeZoneUTCArray[$number][$key]["country_time"] = $date_utc->format("d-M-Y h:i A");


                    }
                }
                $number++;
            }
            if($countryTimeZoneUTCArray) {
                return json_encode($countryTimeZoneUTCArray);
            }
            else {
                return 0;
            }
        }
        else {
            return 0;
        }
        
    }

    public function auto_getCountryTimeAccordingToTimezone($date, $time, $countryId, $timeZoneId = null) {
        $countryTimezoneTimestampArray = array();

        if($date & $time) {
            $date = $date." ".$time;
            if($timeZoneId) {
                $timeZoneArray = $this->Timezone_model->get_timezone_by_timezone_id($timeZoneId);

                if(strstr( $timeZoneArray['utc'],"+")) {
                    $utcTimezone = str_replace("+","-", $timeZoneArray['utc']);
                }
                elseif(strstr( $timeZoneArray['utc'],"-")) {
                    $utcTimezone = str_replace("-","+", $timeZoneArray['utc']);
                }
                
                $GMT_dateObj        = new \DateTime($date);
                $GMT_dateObj->setTimeZone(new DateTimeZone($utcTimezone));
                $GMT_date           = $GMT_dateObj->format("Y-m-d h:i A");
        
                $dateObj        = new \DateTime($GMT_date);
                $dateObj->setTimeZone(new DateTimeZone(DEFAULT_TIMEZONE_UTC));
                $countryTimezoneTimestampArray[] = strtotime($dateObj->format("Y-m-d h:i A"));

            }
            else {
                $countryTimezones = $this->Timezone_model->get_timezone_utc_by_country_id($countryId);

                if(!$countryTimezones) {
                    $countryTimezones = $this->Timezone_model->get_timezone_utc_by_country_id(INDIA_ID);
                }

                foreach($countryTimezones as $countryTimezone) {
                    if(strstr($countryTimezone['utc'],"+")) {
                        $utcTimezone = str_replace("+","-",$countryTimezone['utc']);
                    }
                    elseif(strstr($countryTimezone['utc'],"-")) {
                        $utcTimezone = str_replace("-","+",$countryTimezone['utc']);
                    }
                    
                    $GMT_dateObj        = new \DateTime($date);
                    $GMT_dateObj->setTimeZone(new DateTimeZone($utcTimezone));
                    $GMT_date           = $GMT_dateObj->format("Y-m-d h:i A");
            
                    $dateObj        = new \DateTime($GMT_date);
                    $dateObj->setTimeZone(new DateTimeZone(DEFAULT_TIMEZONE_UTC));
                    $countryTimezoneTimestampArray[] = strtotime($dateObj->format("Y-m-d h:i A"));
                }
            }
        }

        return $countryTimezoneTimestampArray;
    }
}
