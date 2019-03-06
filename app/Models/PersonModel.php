<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request as Request;
use Illuminate\Support\Facades\Auth as Auth;

class PersonModel extends Model {

    protected $table = 'person';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * метод за добавяне на всички служители
     * @param Request $req
     * @param type $companyId
     * @return type
     */
    public function allPerson(Request $req, $companyId = null) {
        $query = $this->
                join('position ', 'person.position', '=', 'position.id')
                ->leftJoin('city ', 'person.city', '=', 'city.id')
                ->leftJoin('country ', 'city.country_id', '=', 'country.id')
                ->leftJoin('company', 'person.company', '=', 'company.id')
                ->select('person.id'
                , 'person.name'
                , 'person.EGN'
                , 'person.email'
                , 'position.name as position'
                , 'company.name AS company'
                , 'birthDate'
                , 'city.name as city');
        if (array_key_exists("search", $req->all())) {
            foreach ($req->get('search') as $column => $searchValue) {
                $query->where('person.' . $column, 'like', '%' . $searchValue . '%');
            }
        }
        if ($companyId != null) {
            $query->where('company', $companyId);
        }
        if (Auth::user()->role->toArray()[0]['name'] != Role::all()->toArray()[0]['name']) {
            $query->where('person.user_id', Auth::user()->id);
        }
        $query->orderBy('person.' . $req->input('ORDER', 'id'), 'ASC');
        return $query->paginate($req->input('list', 5));
    }

    /**
     * метод за изтриване на служител
     * @param type $id
     * @return boolean
     */
    public function deletePerson($id) {
        $person = PersonModel::find($id);
        if ($person->delete()) {
            return true;
        }
        return FALSE;
    }

    /**
     * метод за записване на служител
     * @param type $data
     * @return boolean
     */
    public function savePurson($data) {
        $person = new PersonModel();
        $person->name = $data['name'];
        $person->EGN = $data['EGN'];
        $person->email = $data['email'];
        $person->company = $data['companyid'];
        $person->position = $data['position'];
        $person->birthDate = $data['date'];
        $person->city = $data['city'];
        $person->country = $data['country'];
        if ($person->save()) {
            return true;
        }
        return false;
    }

    /**
     * метод, който връща един служител по неговото ид
     * @param type $id
     * @return type
     */
    public function findPerson($id) {
        return PersonModel::find($id);
    }

    /**
     * метод за редактиране на служител
     * @param type $data
     * @return type
     */
    public function updatePerson($data) {
//        echo"<pre>";
//        print_r($data);
//        echo"</pre>";
//        

        $person = $this->findPerson($data['id']);
        $person->name = $data['name'];
        $person->EGN = $data['EGN'];
        $person->email = $data['email'];
        $person->company = $data['companyid'];
        $person->position = $data['position'];
        $person->birthDate = $data['date'];
        $person->country = $data['country'];
        $person->city = $data['city'];

        return ($person->save()) ? TRUE : FALSE;
    }

    public function changePosition($posizitonId, $personsIdArray) {
        foreach ($personsIdArray as $personId) {
            $person = $this->find($personId);
            $person->position = $posizitonId;
            $person->save();
        }
        return true;
    }

}
