<template>
    <jet-form-section @submitted="updateProfileInformation">

        <template #form>

            <!-- Email -->
            <div class="col-span-4 sm:col-span-4">
                <jet-label for="email" value="Email" />
                <jet-input id="email" type="email"  v-model="inviteUserForm.email" />
                <jet-input-error :message="inviteUserForm.errors.email" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <jet-action-message :on="inviteUserForm.recentlySuccessful" class="mr-3">
                Sent.
            </jet-action-message>

            <jet-button :class="{ 'opacity-25': inviteUserForm.processing }" :disabled="inviteUserForm.processing">
                Invite
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
import JetButton from '@/Jetstream/Button'
import JetFormSection from '@/Jetstream/FormSection'
import JetInput from '@/Jetstream/Input'
import JetInputError from '@/Jetstream/InputError'
import JetLabel from '@/Jetstream/Label'
import JetActionMessage from '@/Jetstream/ActionMessage'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'

export default {
    components: {
        JetActionMessage,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
        JetSecondaryButton,
    },

    props: ['user'],

    data() {
        return {
            inviteUserForm: this.$inertia.form({
                email: '',
                token: null,
            })

        }
    },

    methods: {
        addUser(){
            this.inviteUserForm.post(route('users.invite',this.user)),{
                errorBag: 'addUser',
                preserveScroll: true,
                onSuccess: () => this.inviteUserForm.reset(),
            }
        },






    },
}
</script>
