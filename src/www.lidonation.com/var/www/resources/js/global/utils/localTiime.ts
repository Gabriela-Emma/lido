import moment from "moment-timezone";

export function localTime(time)  {
    return moment(time).local().format('MMMM Do YYYY, h:mm:ss A');
}
