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
                    <div v-can="'view-all-holidays'">
                        <AllHolidays></AllHolidays>
                    </div>

                    <div v-can="'view-own-holidays'" >
                        <div class="xl:flex ">

                            <MyHolidays></MyHolidays>
                            <TakeHolidayForm class="self-end mb-6 mr-6"></TakeHolidayForm>
                        </div>
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
import TakeHolidayForm from "@/components/TakeHolidayForm";

export default {
    components: {
        AppLayout,
        AllHolidays,
        MyHolidays,
        TakeHolidayForm,


    },
}
</script>
