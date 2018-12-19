<template>
    <div>
        <div v-if="signedIn">
            <div class="form-group">
                    <textarea
                        name="body"
                        id="body"
                        class="form-control"
                        placeholder="Have something to say?"
                        aria-describedby="helpId"
                        required
                        v-model="body"></textarea>
                <small id="helpId" class="text-muted">Help text</small>
            </div>
            <button type="submit" class="btn btn-default" @click="addReply">Submit</button>
        </div>
        <p class="text-center" v-else>Please <a :href="logInRoute">sign in</a> to participate in the
            forum.</p>
    </div>
</template>

<script>
    export default {

        data() {
            return {
                body: '',
            }
        },

        computed: {
            signedIn() {
                return window.App.signedIn;
            },
            logInRoute() {
                return route('login');
            }
        },

        methods: {
            addReply() {
                axios.post(location.pathname + '/replies', {body: this.body})
                    .then(response => {
                        this.body = '';

                        flash('Your reply has been posted.');

                        this.$emit('created', response.data);
                    })
            }
        }
    }
</script>
