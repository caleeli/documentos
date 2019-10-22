import moment from "moment";

moment.fn.addWorkdays = function (days) {
    var increment = days / Math.abs(days);
    var date = this.clone().add(Math.floor(Math.abs(days) / 5) * 7 * increment, 'days');
    var remaining = days % 5;
    while (remaining != 0) {
        date.add(increment, 'days');
        if (date.isoWeekday() !== 6 && date.isoWeekday() !== 7)
            remaining -= increment;
    }
    return date;
};

moment.fn.getBusinessDays = function (startDate) {
    
    var startDateMoment = moment(startDate);
    var endDateMoment = this;//moment(endDate)
    var days = Math.round(startDateMoment.diff(endDateMoment, 'days') - startDateMoment.diff(endDateMoment, 'days') / 7 * 2);
    if (endDateMoment.day() === 6) {
        days--;
    }
    if (startDateMoment.day() === 7) {
        days--;
    }
    return days;
}

export default moment;
