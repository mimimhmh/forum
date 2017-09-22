<script>
    export default {
        props: ['attributes'],

        data() {
            return {
                editing: false,
                body: this.attributes.body,
                previousBody: this.attributes.body
            };
        },

        methods: {
            update() {
                //only POST method can work correctly
//                axios.post('/replies/' + this.attributes.id, {
//                    body: this.body
//                }).then(() => {
//                    this.previousBody = this.body;
//                    this.editing = false;
//                    flash('updated!');
//                }).catch((error)=>{
//                    console.log(error.response.data)
//                });
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '/replies/' + this.attributes.id,
                    type : 'PATCH',
                    data: {
                        body: this.body
                    },
                    success: function() {
                        flash('updated!');
                    }
                });

                this.previousBody = this.body;
                this.editing = false;
            },

            cancel() {
                this.body = this.previousBody;
                this.editing = false;
            },

            destroy() {
                axios.delete('/replies/' + this.attributes.id);

                $(this.$el).fadeOut(300, () => {
                    flash('Your reply has been deleted.');
                });
            }
        }
    }
</script>

