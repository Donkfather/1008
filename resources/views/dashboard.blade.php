@extends('layouts.app')
@section('content')
    <div class="md:w-2/3 mx-auto">
        <div class="mb-10 bg-grey-lighter pl-4 text-center flex justify-between items-center">
            <h3>
                Salut @{{user.name}}
            </h3>
            <a class="m-3 inline-block border-2 border-blue text-blue hover:bg-blue hover:text-white p-2 no-underline"
               href="/auth/logout">Logout</a>
        </div>

        <div class="px-2 md:px-0">
            <span class="text-red-dark">Pentru a da checkin trebuie sa aveti locatia pornita si sa permiteti acessul.</span>
            <br>
            <br>
            Pentru ca locatia exacta nu este utila in acest caz pentru a oferi mai multa <i>securitate</i> inainte de a o trimite la server
            o modificam cu o valoare aleatoare dar care nu schimba prea mult.
            <br>
            Toate <i>conturile</i> vor fi sterse in data de 11 August.
            <br>
            Nu exista nicio legatura intre locatie si cel care a trimis-o.
        </div>

        <div class="mt-10 mb-10 px-2 md:px-0">

            <div v-for="(event,index) in events" :key="event.id"
                 class="bg-grey-lighter flex justify-between p-3 items-center rounded mb-3 cursor-pointer hover:bg-green-lightest"
                 :class="{'bg-green-lightest':selectedEvent === index}"
                 @click="$store.commit('changeSelectedEvent',index)"
            >
                <div class="flex">
                    <div class="flex-shrink p-2 w-3 h-3" v-show="selectedEvent === index">&checkmark;</div>
                    <div class="pl-4 flex flex-col">
                        <div>
                            <span v-text="event.name"></span>
                            <span v-if="event.total_checkedin > 0">(@{{event.total_checkedin}} @{{event.total_checkedin>1?'persoane':'persoana'}})</span>
                        </div>
                        <span class="text-grey-dark">@{{moment(event.start_date).format('DMMM H:mm')}} - @{{moment(event.end_date).format('DMMM H:mm')}}</span>
                    </div>
                </div>
                <div v-if="event.status === 'active'">
                    <button v-if="!event.user_status" @click.stop="checkIn(event)" class="bg-red-light text-grey-lighter p-3 inline-block font-bold">Check in</button>
                    <span v-if="event.user_status && event.user_status.checkin_at" class="bg-grey-light text-grey-dark p-3 inline-block font-bold">Already Checked In at @{{moment(event.user_status.used_at).format('DMMM H:mm')}}</span>
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