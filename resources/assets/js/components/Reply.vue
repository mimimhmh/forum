<template>
    <div class="panel panel-default">
        <div :id="'reply-'+id" class="panel-heading">
            <div class="level">
                <h5 class="flex">
                    <a :href="'/profiles/'+data.owner.name"
                    v-text="data.owner.name">
                    </a> said
                    {{ data.created_at }}...
                </h5>

                <div v-if="signedIn">
                    <favorite :reply="data">

                    </favorite>
                </div>
            </div>
        </div>


        <div class="panel-body">
            <div v-if="editing">

                <div class="form-group">
                    <textarea class="form-control" name="body" v-model="body" required></textarea>
                </div>

                <button class="btn btn-primary btn-xs" @click="update">Update</button>
                <button class="btn btn-link btn-xs" @click="cancel">Cancel</button>
            </div>

            <div v-else v-text="body"></div>

        </div>

        <!--@can('update', $reply)-->
        <div class="panel-footer level" v-if="canUpdate">
            <button class="btn btn-info btn-xs mr-1"
                    @click="editing = true">
                Edit
            </button>

            <button class="btn btn-danger btn-xs"
                    @click="destroy">
                Delete
            </button>

        </div>
        <!--@endcan-->
    </div>

</template>

<script>
    import Favorite from './Favorite.vue';

    export default {
        props: ['data'],

        components: { Favorite },

        data() {
            return {
                editing: false,
                body: this.data.body,
                id: this.data.id,
                previousBody: this.data.body
            };
        },

        computed: {
            signedIn(){
                return window.App.signedIn;
            },

            canUpdate() {
                return this.authorize(user => this.data.user_id == user.id);
            }
        },

        methods: {
            update() {
                //only POST method can work correctly
//                axios.patch('/replies/' + this.data.id, {
//                    body: this.body
//                }).then(() => {
//                    this.previousBody = this.body;
//                    this.editing = false;
//                    flash('updated!');
//                }).catch((error)=>{
//                    console.log(error.response.data)
//                });
                if($.trim(this.body) === "")
                {
                    alert("Reply should have body.");
                    return;
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '/replies/' + this.data.id,
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
                axios.delete('/replies/' + this.data.id);

                this.$emit('deleted', this.data.id);
            }
        }
    }
</script>

