<template>
    <div>
        <h5>
            <span>Api Tokens </span>
            <button type="button" class="btn btn-info" style="float: right;" @click.prevent="showModal = true">
                <i class="fa fa-plus"></i> Add new Token
            </button>
        </h5>
        <p>Send transaction emails using api tokens</p>
        <div class="card mb-3">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Token Name</th>
                            <th>Api Token</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="loading">
                            <td colspan="4"><h5>Loading...</h5></td>
                        </tr>
                        <template v-else>
                            <template v-if="tokens.length > 0">
                                <tr v-for="token in tokens" :key="token.id">
                                    <td>{{ token.name }}</td>
                                    <td>
                                        <span @dblclick="copyUrl">
                                            {{ token.access_token }}
                                        </span>
                                    </td>
                                    <td>{{ token.created_at }}</td>
                                    <td @click.prevent="removeToken(token)">
                                        <button class="btn btn-xs btn-danger">Remove</button> 
                                    </td>
                                </tr>
                            </template>
                            <template v-else>
                                <td colspan="4">No tokens found.</td>
                            </template>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>

        <div v-if="showModal">
            <transition name="modal">
                <div class="modal-mask">
                    <div class="modal-wrapper">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add new token</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" @click="showModal = false">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Token Name</label>
                                <input type="text" v-model="token.name" class="form-control" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="showModal = false">Close</button>
                            <button type="button" class="btn btn-primary" @click.prevent="createToken">Save changes</button>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
            </transition>
        </div>
    </div>    
</template>

<script>
import axios from 'axios'

export default {
    data() {
        return {
            token: {
                name
            },
            tokens: [],
            loading: false,
            showModal: false
        };
    },
    methods: {
        async loadTokens() {
            this.loading = true;
            try {
                const { data: { tokens } } = await axios.get('tokens');
                this.tokens = tokens;
                this.loading = false;
            } catch (error) {
                this.$notify({ 
                    type: 'error', 
                    title: 'Server Error',
                    text: error.message 
                });
                this.loading = false;
            }
        },
        async removeToken(token) {
            try {
                await axios.delete(`tokens/${token.id}`);
                this.tokens = this.tokens.filter(tkn => tkn.id !== token.id);
                this.$notify({ 
                    type: 'success', 
                    title: 'Token removed',
                    text: 'Api access token has been removed.' 
                });
            } catch (error) {
                this.$notify({ 
                    type: 'error', 
                    title: 'Error removing token',
                    text: error.message 
                });
            }
        },
        async createToken() {
            try {
                const { data } = await axios.post('tokens', this.token);
                this.token.name = '';
                this.showModal = false;
                this.tokens = [data.token, ...this.tokens];
                this.$notify({ 
                    type: 'success', 
                    title: 'Token created',
                    text: 'Api access token has been created.' 
                });
            } catch (error) {
                this.$notify({ 
                    type: 'error', 
                    title: 'Error!',
                    text: error.message
                });
            }
        },
        copyUrl(e) {
            const el = document.createElement('textarea');  
            el.value = e.target.innerText;                                 
            el.setAttribute('readonly', '');                
            el.style.position = 'absolute';                     
            el.style.left = '-9999px';                      
            document.body.appendChild(el);                  
            const selected =  document.getSelection().rangeCount > 0  ? document.getSelection().getRangeAt(0) : false;                                    
            el.select();                                    
            document.execCommand('copy');                   
            document.body.removeChild(el);                  
            if (selected) {    
                this.$notify({ 
                    type: 'success', 
                    title: 'Copied!',
                    text: 'Api token copied to clipboard'
                });                            
                document.getSelection().removeAllRanges();    
                document.getSelection().addRange(selected);   
            }
        }

    },
    created() {
        this.loadTokens();    
    }
}
</script>