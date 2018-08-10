@extends('layouts.app')
@section('content')
    <div class="flex justify-center content-center h-full">

        <div class="px-4 py-6 md:w-2/3 self-center text-center bg-grey-lightest">
            <div>
                Bun venit, momentan avem {{ cache()->remember('total-users',5,function(){ return App\User::count();})}} utilizatori care ni s-au alaturat.
                <br>
                Am creat aceasta aplicatia pentru a avea posibilitatea de a contracara minciunile din media despre numarul de oameni prezenti.
                <br>
                <br>
                Avand in vedere importanta securitatii am incercat sa construiesc aplicatia in asa fel incat sa nu salveze alte date decat strictul necesar
                pentru functionarea ei astfel ca urmatoarele date vor fi salvate:
                <br>
                <br>
                <ul class="text-left">
                    <li>Numele contului din facebook (pentru a iti arata pe ce cont esti logat)</li>
                    <li>ID-ul profilului din facebook (pentru autentificare)</li>
                    <li>O legatura intre contul tau si evenimentul in care ai dat checkin (pentru a putea pastra un checkin/cont/eveniment)</li>
                    <li>Coordonatele locatiei tale din momentul in care apesi checkin dar nu cu o acuratete prea mare</li>
                </ul>
                <br>
                <br>
                <br>

            </div>
            <a class=" inline-block bg-blue p-3 text-white font-bold no-underline" href="/auth/facebook/redirect">Continua cu Facebook</a>
        </div>
    </div>
@endsection
