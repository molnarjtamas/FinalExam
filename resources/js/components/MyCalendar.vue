<template>
    <vue-event-calendar :events="myEvents"></vue-event-calendar>
</template>

<script>
import axios from "axios";
import moment from "moment";


export default {
    data() {
        return {
            link: `/holidays/${this.$page.props.user.id}`,
            myEvents: [],

        }
    },

    mounted() {
        this.fetchHolidaysIntoEvents()
    },

    methods: {

        fetchHolidaysIntoEvents() {
            axios.get(this.link)
                .then(res => {
                    let starts = this.getEventsStart(res.data.data)
                    let ends = this.getEventsEnd(res.data.data)
                    this.myEvents = [...starts,...ends]

                }).catch(err => {
                console.log(err)
            })
        },
        getEventsStart(holidays){
            // holidays.forEach(holiday => console.log(holiday));
            return holidays
                .filter(holiday => holiday.approved > 0)
                .map(holiday => ({title: holiday.type + ' vacation starts', date: this.formatDate(holiday.start_date), desc: holiday.description}));
        },

        getEventsEnd(holidays){
            // holidays.forEach(holiday => console.log(holiday));
            return holidays
                .filter(holiday => holiday.approved > 0)
                .map(holiday => ({title: holiday.type + ' vacation ends', date: this.formatDate(holiday.end_date), desc: holiday.description}));
        },
        formatDate(date){
            return moment(date).format("YYYY/MM/DD")
        },


    }
}
</script>
