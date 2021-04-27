<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Holiday
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div v-if="canViewAllHolidays">
                        <AllCalendar></AllCalendar>
                    </div>

                    <div v-if="canViewOwnHolidays" >
                        <div class="xl:flex ">
                            <MyCalendar></MyCalendar>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout';
import AllCalendar from "@/components/AllCalendar";
import MyCalendar from "@/components/MyCalendar";
import axios from "axios";
import moment from "moment";

export default {
    components: {
        AppLayout,
        AllCalendar,
        MyCalendar,



    },
    data() {
        return {
            permissions: null,
        }
    },
    computed:
        {
            canViewAllHolidays: function (){
                return this.permissions ? this.checkPermission(this.permissions,'view-all-holidays') : false
            },
            canViewOwnHolidays: function (){
                return this.permissions ? this.checkPermission(this.permissions,'view-own-holidays') : false
            }
        },
    mounted() {
        this.fetchPermissions()
    },

    methods: {
        fetchPermissions() {
            axios.get('user/permissions')
                .then( response => {
                    this.permissions = response.data

                }).catch(err => {
                console.log(err)
            })
        },

        checkPermission(permissions,permission) {
            return permissions.some(element => element === permission);
        },

    }
}
</script>
