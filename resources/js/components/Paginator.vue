<template>
    <nav aria-label="Page navigation example" v-if="shouldPaginate">
        <ul class="pagination">
            <li :class="prevLinkClasses"><a class="page-link" href="#" rel="prev"
                                            @click.prevent="page--">Previous</a>
            </li>

            <li :class="nextLinkClasses"><a class="page-link" href="#" rel="next"
                                            @click.prevent="page++">Next</a></li>
        </ul>
    </nav>
</template>
<script>
    import URL from '../mixins/url';

    export default {
        props: ['dataSet'],
        data() {
            return {
                page: 1,
                nextUrl: false,
                prevUrl: false,
            };
        },

        watch: {
            dataSet() {
                this.page = this.dataSet.current_page;
                this.prevUrl = this.dataSet.prev_page_url;
                this.nextUrl = this.dataSet.next_page_url;
            },
            page() {
                this.broadcast().updateUrl();
            },
        },

        computed: {
            shouldPaginate() {
                return !!this.prevUrl || !!this.nextUrl;
            },
            prevLinkClasses() {
                return {
                    'page-item': true,
                    'disabled': !(!!this.prevUrl),
                };
            },
            nextLinkClasses() {
                return {
                    'page-item': true,
                    'disabled': !(!!this.nextUrl),
                };
            },
        },

        methods: {
            broadcast() {
                return this.$emit('changed-page', this.page);
            },

            updateUrl() {
                history.pushState(null, null, '?' + (new URL).withQuery({page: this.page}));
                return this;
            },
        },


    }
</script>
