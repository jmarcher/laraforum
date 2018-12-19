<template>
    <div :id="`reply-${this.data.id}`" class="card">
        <div class="card-header">
            <div class="level">
                <h5 class="flex">
                    <a :href="ownerProfileUrl" v-text="this.data.owner.name"></a> <span>said</span> <span
                    v-text="ago"></span>
                </h5>
                <!--@auth-->
                <favorite :reply="this.data" v-if="signedIn"></favorite>
                <!--@endauth-->
            </div>
        </div>
        <div class="card-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea name="body" id="" cols="30" rows="10" class="form-control" v-model="body"></textarea>
                </div>

                <div class="btn btn-sm btn-primary" @click="update">Update</div>
                <div class="btn btn-sm btn-link" @click="editing = false">Cancel</div>
            </div>
            <div v-else v-text="body"></div>
        </div>
        <div class="card-footer" v-if="canUpdate">
            <div class="level">
                <div class="btn btn-sm btn-secondary" @click="editing = true">Edit</div>
                <button type="submit" class="btn btn-danger btn-sm ml-1"
                        @click="destroy"> Delete
                </button>
            </div>
        </div>
    </div>
</template>
<script>
    import Favorite from './Favorite.vue';
    import moment from 'moment';

    export default {
        props: ['data'],

        components: {Favorite},

        data() {
            return {
                editing: false,
                body: this.data.body,
            };
        },
        computed: {
            ago() {
                return moment(this.data.created_at).fromNow();
            },
            signedIn() {
                return window.App.signedIn;
            },
            ownerProfileUrl() {
                return route('profile.get', this.data.owner.name);
            },
            canUpdate() {
                return this.authorize(user => user.id == this.data.user_id);
            },
        },
        methods: {
            update() {
                axios.patch(`/replies/${this.data.id}`, {
                    body: this.body,
                });

                this.editing = false;

                flash('Updated');
            },
            destroy() {
                axios.delete(`/replies/${this.data.id}`);

                this.$emit('deleted', this.data.id);

            }
        }
    }
</script>
