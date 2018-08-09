@extends('layouts.app')
@section('content')
    <div class="sm:w-2/3 mx-auto">
        <div class="mb-10 bg-grey-lighter pl-4 text-center flex justify-between items-center">
            <h3>
                Salut @{{user.name}}
            </h3>
            <a class="m-3 inline-block border-2 border-blue text-blue hover:bg-blue hover:text-white p-2 no-underline"
               href="/auth/logout">Logout</a>
        </div>

        <div>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda delectus distinctio harum, iure molestiae nulla perferendis sint sit tempora vero voluptas voluptatem? Asperiores consequatur consequuntur ducimus fugit ipsam ipsum sed.
        </div>

        <div class="mt-10 mb-10">

            <div v-for="(event,index) in events" :key="event.id"
                 class="bg-grey-lighter flex justify-between p-3 items-center rounded mb-3 cursor-pointer"
                 :class="{'bg-green-lightest':selectedEvent === index}"
                 @click="$store.commit('changeSelectedEvent',index)"
            >
                <div class="flex">
                    <div class="flex-shrink p-2 w-3 h-3" v-show="selectedEvent === index">&checkmark;</div>
                    <div class="pl-4 flex flex-col">
                        <span v-text="event.name"></span>
                        <span class="text-grey-dark">@{{moment(event.start_date).format('DMMM H:mm')}} - @{{moment(event.end_date).format('DMMM H:mm')}}</span>
                    </div>
                </div>
                <div v-if="event.status === 'active'">
                    <button v-if="event.user_token && event.user_token.token && event.user_token.used_at === null" @click="checkIn(event)" class="bg-red-light text-grey-lighter p-3 inline-block font-bold">Check in</button>
                    <span v-if="event.user_token && event.user_token.used_at" class="bg-grey-light text-grey-dark p-3 inline-block font-bold">Already Checked In at @{{moment(event.user_token.used_at).format('DMMM H:mm')}}</span>
                </div>
                <div v-if="event.status === 'past'">
                    Acest eveniment s-a terminat
                </div>
                <div v-if="event.status === 'future'">
                    Va urma
                </div>
            </div>

        </div>

        <div>
            <google-map/>
        </div>

    </div>
@endsection