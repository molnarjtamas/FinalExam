<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Holiday
            </h2>
            <h3 v-if="getResult ==='no'" class="text-red-600">
                {{getMessage}}
            </h3>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div v-if="canViewAllHolidays">
                        <AllHolidays></AllHolidays>
                    </div>
                    <div v-if="canViewOwnHolidays">
                        <MyHolidays v-bind:message="getMessage" v-bind:success:="getResult"></MyHolidays>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout';
import AllHolidays from "@/components/AllHolidays";
import MyHolidays from "@/components/MyHolidays";

import axios from "axios";


export default {
    components: {
        AppLayout,
        AllHolidays,
        MyHolidays,
    },
    props:['success','message'],

    data() {
        return {
            permissions: null,
        }
    },
    computed:
        {
            getResult: function () {
                return this.success;
            },
            getMessage: function () {
                return this.message;
            },
            canViewAllHolidays: function () {
                return this.permissions ? this.checkPermission(this.permissions, 'view-all-holidays') : false
            },
            canViewOwnHolidays: function () {
                return this.permissions ? this.checkPermission(this.permissions, 'view-own-holidays') : false
            }
        },
    mounted() {
        this.fetchPermissions()
    },

    methods: {
        fetchPermissions() {
            axios.get('user/permissions')
                .then(response => {
                    this.permissions = response.data

                }).catch(err => {
                console.log(err)
            })
        },

        checkPermission(permissions, permission) {
            return permissions.some(element => element === permission);
        },

    }
}
</script>
