new Vue({
    el          : '#woyp-playlist',
    data() {
        return {
            errors      : [],
            playlist    : [],
            active      : false,
            nextToken   : ''
        }
    },
    methods     : {
        getPlaylist() {
            axios({
                url     : woyp.ajax.url,
                method  : 'POST',
                data    : Qs.stringify({
                    action          : 'getPlaylist',
                    nextPageToken   : this.nextToken
                })
            }).then( response => {
                if( response.data.errors ) {
                    this.errors = response.data.errors
                } else {
                    if( response.data.items ) {
                        response.data.items.forEach( item => {
                            this.playlist.push( item )
                        })

                        this.nextToken = response.data.nextPageToken
                    } else {
                        this.nextToken = ''
                    }
                }
            }).catch( error => {
                console.log( error )
            })
        }
    },
    created() {
        this.getPlaylist()
    }
}) 