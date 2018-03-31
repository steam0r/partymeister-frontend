<html>
<head>
    <link rel="stylesheet" href="{{asset('css/mini-dark.min.css')}}">
    <style type="text/css">
        .special {
            background-color: #fc4981;
        }

        .active, .active:focus {
            background-color: #77e15d;
            color: black;
        }
    </style>
</head>
<body>

<div id="live-voting">
    <h2>Live voting</h2>
    <h3>@{{ competition }}</h3>
    {{--<div v-for="let e of entries"></div>--}}

    <div class="card" v-for="entry in entries">
        <div class="section" v-bind:class="{ special: (entry.vote.data[0] && entry.vote.data[0].special_vote)}">
            <h4><strong># @{{ entry.entry_number }}</strong> @{{ entry.title }} by @{{ entry.author }}</h4>
            <div class="button-group">
                <button type="button" data-value="0" @click="updateVote(entry, 0)"
                        v-bind:class="{ active: (entry.vote.data[0] && entry.vote.data[0].points) == 0}">-
                </button>
                <button type="button" data-value="1" @click="updateVote(entry, 1)"
                        v-bind:class="{ active: (entry.vote.data[0] && entry.vote.data[0].points) == 1}">1
                </button>
                <button type="button" data-value="2" @click="updateVote(entry, 2)"
                        v-bind:class="{ active: (entry.vote.data[0] && entry.vote.data[0].points) == 2}">2
                </button>
                <button type="button" data-value="3" @click="updateVote(entry, 3)"
                        v-bind:class="{ active: (entry.vote.data[0] && entry.vote.data[0].points) == 3}">3
                </button>
                <button type="button" data-value="4" @click="updateVote(entry, 4)"
                        v-bind:class="{ active: (entry.vote.data[0] && entry.vote.data[0].points) == 4}">4
                </button>
                <button type="button" data-value="5" @click="updateVote(entry, 5)"
                        v-bind:class="{ active: (entry.vote.data[0] && entry.vote.data[0].points) == 5}">5
                </button>
            </div>
            <div style="text-align: center">
                <input name="comment" placeholder="Comment" v-model="entry.comment" style="text-align: center">
                <button @click="updateVote(entry)">Send</button>
                <button v-if="!(entry.vote.data[0] && entry.vote.data[0].special_vote)" @click="markSpecial(entry, true)">&hearts; My party
                    favourite &hearts;
                </button>
                <button v-if="entry.vote.data[0] && entry.vote.data[0].special_vote" @click="markSpecial(entry, false)">&#x2639; Not my favourite
                    anymore &#x2639;
                </button>
            </div>
            <span class="toast secondary" v-if="success">Saved</span>
            <span class="toast secondary" v-if="error">Error</span>
        </div>
    </div>
</div>

<script type="text/javascript" src="{{asset('js/vue.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/axios.min.js')}}"></script>
<script>
    var liveVoting = new Vue({
        el: '#live-voting',
        data: {
            competition: '',
            entries: [],
            success: false,
            error: false,
        },
        methods: {
            refresh: function () {
                axios.get('{{url('/api/profile/'.$visitor->api_token.'/votes/live')}}').then(function (response) {
                    var entries = response.data.data;
                    if (entries.length > 0) {
                        liveVoting.competition = entries[0].competition;
                    }
                    // Save state
                    for (let [index, ne] of entries.entries()) {
                        if (entries[index].vote.data.length == 0) {
                            entries[index].vote.data.push({
                                comment: '',
                                special_vote: false,
                                points: 0
                            });
                        }
                        entries[index].comment = entries[index].vote.data[0].comment;
                        // Save state
                        for (let e of liveVoting.entries) {
                            if (e.id == ne.id) {
                                if (entries[index].vote.data.length == 0 || entries[index].vote.data[0].comment != e.comment) {
                                    entries[index].comment = e.comment;
                                }
                            }
                        }
                    }
                    liveVoting.entries = entries;
                });
            },
            markSpecial: function (entry, value) {
                for (let e of this.entries) {
                    if (e.vote.data[0].special_vote == true) {
                        e.vote.data[0].special_vote = false;
                    }
                    // if (e.vote.data.special_vote) {
                    //     Vue.set(e.vote.data, 'special_vote', !value);
                    // }
                }
                entry.vote.data[0].special_vote = value;
                this.saveVote(entry, value);
            },
            updateVote: function (entry, points) {
                if (points != undefined) {
                    entry.vote.data[0].points = points;
                }
                this.saveVote(entry);
            },
            saveVote: function (entry, special) {
                var data = {
                    entry_id: entry.id,
                    competition_id: entry.competition_id,
                    vote_category_id: 1,
                    points: entry.vote.data[0].points,
                    comment: entry.comment,
                    live: true
                };


                if (special != undefined) {
                    data.special_vote = special;
                }

                axios.post('{{route('ajax.votes.submit', ['api_token' => $visitor->api_token])}}', data).then(function (response) {
                    if (response.data.success) {
                        liveVoting.success = true;
                        window.setTimeout(function () {
                            liveVoting.success = false
                        }, 2000);
                    } else if (response.data.error) {
                        liveVoting.error = true;
                        window.setTimeout(function () {
                            liveVoting.error = false
                        }, 2000);
                    }
                });
            }
        },
        mounted: function () {

            this.refresh();

            window.setInterval(this.refresh, 20000);

        }
    });
</script>
</body>
</html>
