<template>

    <div class="mt-8">


        <full-calendar :events="events" locale="en"></full-calendar>

    </div>
</template>

<script>


import axios from "axios";


export default {
    components : {
        'full-calendar': require('vue-fullcalendar')
    },
    data () {
        return {
            link: '/holidays',
            holidays: {},
            events: {}
        }
    },
    mounted() {
        this.fetchHolidaysIntoEvents();

    },
    methods: {

        fetchHolidaysIntoEvents() {
            axios.get(this.link)
                .then(res => {
                    this.events = this.convertToEvents(res.data.data)
                    console.log(this.events);
                }).catch(err => {
                console.log(err)
            })
        },
        convertToEvents(holidays){
            // holidays.forEach(holiday => console.log(holiday));
            let events = holidays
                .filter(holiday => holiday.approved > 0 )
                .map(holiday => ({title: holiday.user.name +' - '+ holiday.description, start: holiday.start_date, end: holiday.end_date}));
            return events;
        }

    }
}
</script>
