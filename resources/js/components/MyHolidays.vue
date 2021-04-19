<template>

    <div class="mt-8">


        <div class="mt-6">
            <div class="lg:flex justify-between ">
                <div class="lg:flex pl-6">
                    <!-- Logo -->
                    <div class="flex  items-center">
                        <HolidayMark class="self-center block h-44 w-full"/>
                    </div>
                    <div class="self-center text-5xl ml-8 sm:ml-16 font-semibold text-gray-600 uppercase">
                        My holidays
                    </div>
                </div>

            </div>
            <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                <div
                    class="inline-block min-w-1/2 shadow rounded-lg overflow-hidden"
                >
                    <table class="min-w-full leading-normal">
                        <thead class="border-green-800 bg-green-800 text-white  text-left text-xs sm:text-sm font-semibold uppercase tracking-wider">
                        <tr>

                            <th
                                class="px-5 py-3 border-b-2 hidden sm:table-cell "
                            >
                                Type
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 hidden sm:table-cell"
                            >
                                Description
                            </th>
                            <th
                                class="px-5 py-3 border-b-2   "
                            >
                                I leave on
                            </th>
                            <th
                                class="px-5 py-3 border-b-2  "
                            >
                                Until
                            </th>
                            <th
                                class="px-5 py-3 border-b-2   "
                            >
                                Status
                            </th>

                        </tr>
                        </thead>
                        <tbody class="text-xs sm:text-lg">

                        <tr v-for="holiday in holidays" :class="holidayStatusClass(holiday)">

                            <td v-if="holiday" class="py-3 px-5 hidden sm:table-cell">{{ holiday.type }}</td>
                            <td v-if="holiday" class="py-3 px-5 hidden sm:table-cell">{{ holiday.description }}</td>
                            <td v-if="holiday" class="py-3 px-5">{{ formatDate(holiday.start_date )}}</td>
                            <td v-if="holiday" class="py-3 px-5">{{formatDate(holiday.end_date )}}</td>
                            <td v-if="holiday" class="py-3 px-5">
                                <div v-if="holiday.approved">
                                    <CheckMark class="h-8 w-8 ml-2 text-green-700"></CheckMark>

                                </div>
                                <div v-else>
                                    <Waiting class="h-8 w-8 ml-2"></Waiting>
                                </div>
                            </td>


                        </tr>

                        </tbody>
                    </table>
                    <div
                        class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between"
                    >
              <span class="text-xs xs:text-sm text-gray-900"
              >Showing {{ meta.from }} to {{ meta.to }} of {{ meta.total }} Entries</span
              >

                        <div class="inline-flex mt-2 xs:mt-0">
                            <button @click="clickPage('prev')"
                                    class="text-sm bg-green-700 hover:bg-green-900 text-gray-50 font-semibold py-2 px-4 rounded-l"

                            >
                                Prev
                            </button>
                            <button @click="clickPage('next')"
                                    class="text-sm bg-green-700 hover:bg-green-900 text-gray-50 font-semibold py-2 px-4 rounded-r"
                            >
                                Next
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>

import axios from "axios";
import moment from "moment";
import HolidayMark from "@/components/HolidayMark"
import CheckMark from "@/components/CheckMark"
import Waiting from "@/components/Waiting"
export default {
    name: "MyHolidays",


    components: {
        HolidayMark,
        CheckMark,
        Waiting
    },
    data() {
        return {
            link: `/holidays/${this.$page.props.user.id}`,
            holidays: {},
            links: {},
            meta: {},


        }
    },

    computed: {},
    mounted() {
        this.fetchHolidays()
        this.getToday()

    },

    methods: {

        fetchHolidays() {
            axios.get(this.link)
                .then(res => {
                    this.prepareParams(res)
                }).catch(err => {
                console.log(err)
            })
        },


        prepareParams(res) {
            this.holidays = res.data.data
            this.links = res.data.links
            this.meta = res.data.meta
        },

        clickPage(button) {
            if (button === 'prev')
                this.link = this.links.prev

            else
                this.link = this.links.next

            this.fetchHolidays();
        },

        holidayStatusClass(holiday) {
            if ((holiday.start_date < this.getToday()) && (holiday.end_date > this.getToday()))
                return 'active-background'
            else if (holiday.end_date < this.getToday())
                return 'outdated-background'
            else
                return ''
        },

        getToday() {
            return moment().format("YYYY-MM-DD")
        },
        formatDate(date){
            return moment(date).format("MMM Do, YY")
        },

    }

}
</script>
<style>
.active-background {
    background-color: rgb(150, 255, 50);
}

.outdated-background {
    background-color: darkgrey;
    color: grey;
}
</style>
