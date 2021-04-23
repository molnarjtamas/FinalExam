<template>
    <div class="container mx-auto sm:flex justify-center md:flex-row items-center my-12 md:my-24">
        <!--Left Col-->
        <div class="flex flex-col w-full lg:w-1/2 justify-center items-start pt-12 pb-24 px-6">
            <p class="uppercase tracking-loose">The application your employer wants you to use the least.</p>
            <h1 class="font-bold text-8xl my-4 text-green-800">Holi-Day-Off</h1>
            <p class="leading-normal mb-4">“Do not wait until you are dying to go on vacation. I think if I had to give you one piece of advice that would be it. We put things off. We do not mean to, but we do. We carry around the assumption that there is plenty of time to do whatever needs to be done.” – <i>Marty Cauley</i> </p>

            <div v-if="canLogin"  class="flex justify-center w-full">

                <jet-button  v-if="$page.props.user"   >
                    <inertia-link  href="/dashboard" >
                        Go to site
                    </inertia-link>
                </jet-button>

                <template v-else>

                    <jet-button class="self-center" >
                        <inertia-link :href="route('login')">
                            Login
                        </inertia-link>
                    </jet-button>


                </template>
            </div>
        </div>
        <!--Right Col-->
        <div class="w-full lg:w-1/2 lg:py-6 flex justify-end">
            <jet-application-mark class=" h-auto " />
        </div>

    </div>
</template>



<script>
import JetApplicationLogo from "@/Jetstream/ApplicationLogo";
import JetApplicationMark from '@/Jetstream/ApplicationMark';
import JetButton from '@/Jetstream/Button';

export default {
    components:{
        JetApplicationLogo,
        JetApplicationMark,
        JetButton
    },
    props: {
        canLogin: Boolean,
        laravelVersion: String,
        phpVersion: String,
    }
}
</script>
