<template>
    <div>
        Support
    </div>
</template>

<script>
    export default {
        mounted() {
            this.getCategories();
        },

        data() {
            return {
                categories: {}
            }
        },

        methods: {

            getCategories() {
                axios.get(
                    '/data/categories.json'
                ).then(response => {
                        this.categories = response.data;
                    }, error => {

                    }
                );
            },
        },

    }

</script>