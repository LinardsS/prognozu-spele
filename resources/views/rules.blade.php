@extends('layouts.app')

@section('content')
  <h1>Noteikumi</h1>
  <p>Sveicināti Prognozis mājaslapā! </p>
  <p>Šeit Jūs varat sacensties ar draugiem un veikt prognozes uz NHL, NBA, Premjerlīgas, kā arī pašu izveidotām spēlēm!</p>
  <p>Prognozis piedāvā automātisku spēļu ielādi sekojošajām sporta līgām: </p>
  <ul>
    <li>NHL</li>
    <li>NBA</li>
    <li>Anglijas Premjerlīga</li>
  </ul>
  <p>Izveidojot savu prognožu līgu, Jūs varat atķeksēt vienu vai vairākas no šīm opcijām, kas automātiski piesaistīs visas
  tās līgas spēles Jūsu izveidotajai prognožu līgai.</p>
  <p>Lietotājiem ir iespēja izveidot pašiem savas spēles. Šī izveidotā spēle būs unikāla Jūsu prognožu līgai un uz to prognozes varēs veikt tikai tie lietotāji, kas piedalās Jūsu prognožu līgā.</p>
  <p>Visu spēļu prognožu rezultāti tiek apstrādāti vienādi. Ja prognozes veic līgā, kurā min spēles uzvarētāju: </p>
  <ul>
    <li>Par pareizu uzvarētāja uzminēšanu tiek piešķirts 1 (viens) punkts</li>
    <li>Par nepareizu uzvarētāja uzminēšanu punkti netiek piešķirti</li>
  </ul>
  <p>Ja prognozes veic līgā, kurā min spēles rezultātu: </p>
  <ul>
    <li>Par precīzu rezultāta uzminēšanu tiek piešķirti 10 (desmit) punkti</li>
    <li>Ja netiek uzminēts rezultāts, taču ir uzminēta precīza vārtu starpība, tiek piešķirti 5 (pieci) punkti</li>
    <li>Ja netiek uzminēts rezultāts vai vārtu starpība, taču precīzi uzminēts uzvarētājs, tiek piešķirti 3 (trīs) punkti</li>
    <li>Ja netiek uzminēts uzvarētājs, punkti netiek piešķirti</li>
  </ul>
  <p>NHL un NBA spēlēm rezultāts nekad nebūs neizšķirts. Ja šo līgu spēle pamatlaikā beidzas neizšķirti, gala rezultāts tiek vērtēts pēc papildlaika. Jebkura neizšķirta prognoze šīm spēlēm vienmēr rezultēsies ar 0 gūtiem punktiem. </p>
  <p>Premjerlīgas spēlēm rezultāts var būt neizšķirts.</p>
  <p>Prognozis mājaslapā pastāv sekojoši lietotāju noteikumi, kuri jāievēro visiem mājaslapas lietotājiem: </p>
  <ol>
    <li>Lietotāja, līgas vai spēles komandu nosaukumos nedrīkst lietot necenzētus vai citādi aizskarošus vārdus.</li>
    <li>Aizliegts mēģināt piekļūt citu lietotāju sensitīvai informācijai(parolēm, personas datiem utml).</li>
    <li>Aizliegts sūtīt citiem lietotājiem ziņas, kas satur rupju vai aizskarošu valodu.</li>
  </ol>
  <p>Jebkura šo noteikumu pārkāpšana beigsies ar vainīgā lietotāja neatgriezenisku dzēšanu no mājaslapas.
    Tas pats attiecas arī uz līgām vai spēlēm, kuras satur neatļautu valodu to nosaukumos.
  </p>
  <p>Gadījumā, ja lietotājs vēlas izteikt kādu sūdzību, ieteikumu vai norādīt uz kļūdu mājaslapā, tas tiek laipni aicināts izmantot saziņas moduli, ar kura palīdzību iespējams sazināties ar mājaslapas administrāciju.</p>
@endsection
