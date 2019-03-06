<?php

namespace App\Http\Controllers\Person;

use Illuminate\Http\Request as Request;
use App\Http\Controllers\Controller;
use App\Models\CompanyModel as CompanyModel;
use App\Models\PositionModel;
use App\Models\PersonModel;
use App\Http\Requests\StorePersonRequest;
use App\Policies\PersonsPolicy as PersonsPolicy;
use App\Models\CityModel as CityModel;
use App\Models\CountryModel as CountryModel;
use App\Models\CategoryModel as CategoryModel;

class PersonController extends Controller {

    private $personModel;

    public function __construct(PersonModel $person) {
        $this->personModel = $person;
    }

    /**
     * Метод, за извикване на view за показване на всички служители
     * @param Request $req
     * @return type
     */
    public function index(Request $req, PositionModel $position) {
        $this->authorize('person_index', PersonModel::class);

        $data = $this->personModel->allPerson($req, $req->get('id'));
        $this->appends($req, $data);

        if ($req->ajax()) {
            return $data;
        } else {
            return view('Person.index', ['person' => $data, 'position' => $position->getAllPositionArray()]);
        }
    }

    /**
     * Метод за изтриване на служител
     * @param type $id
     * @return type
     */
    public function delete($id) {
        $this->authorize('person_delete', $this->personModel);
        if ($this->personModel->deletePerson($id)) {
            $this->flashMessage('message/person.deletePersonSuccess');
        } else {
            $this->flashMessage('message/person.deletePersonDanger', 'danger');
        }
        return redirect("person/");
    }

    /**
     * Метод за извикване на view за доавяне на служител
     * @param CompanyModel $companyModel
     * @param PositionModel $positionModel
     * @return type
     */
    public function addPerson(CompanyModel $companyModel, PositionModel $positionModel, CountryModel $country, CategoryModel $CategoryModel) {
        $this->authorize('person_add', $this->personModel);
        return view('Person.newPerson', [
            'company' => $companyModel->getNameIdCompany(),
            'position' => $positionModel->getAllPositionArray(),
            'country' => $country->getCountry(),
            'category' => $CategoryModel->getCategory()
        ]);
    }

    /**
     * Метод, който извиква модела за записване на служителя в базата
     * @param Request $req
     * @param StorePersonRequest $person
     * @return type
     */
    public function savePerson(Request $req, StorePersonRequest $person) {

        if ($this->personModel->savePurson($req->all())) {
            $this->flashMessage('message/person.savePersonSuccess');
        } else {
            $this->flashMessage('message/person.savePersonDanger', 'danger');
        }
        return redirect('person/');
    }

    /**
     * метод, който извиква view за редактиране на служител
     * @param type $id
     * @param CompanyModel $companyModel
     * @param PositionModel $positionModel
     * @return type
     */
    public function editPerson($id, CompanyModel $companyModel, PositionModel $positionModel, CountryModel $country, CategoryModel $category) {
        $this->authorize('person_edit', $this->personModel);
        return view('Person.editPerson', ['person' => $this->personModel->findPerson($id),
            'company' => $companyModel->getNameIdCompany(),
            'position' => $positionModel->getAllPositionArray(),
            'country' => $country->getCountry(),
            'category' => $category->getCategory(),
        ]);
    }

    /**
     * метод, който предава на съответния модел даните, за да може да се редактира потребителя
     * @param Request $req
     * @param StorePersonRequest $person
     * @return type
     */
    public function updatePerson(Request $req, StorePersonRequest $person) {


        if ($this->personModel->updatePerson($req->all())) {
            $this->flashMessage('message/person.updatePersonSuccess');
        } else {
            $this->flashMessage('message/person.updatePersonDanger', 'danger');
        }
        return redirect('person/');
    }

    public function getCity(Request $req, CityModel $city) {
        return $city->getCityByCountryId($req->get('id'));
    }

    public function getCompany(Request $req, CompanyModel $company) {

//        $tmp = [];
//        foreach ($company->getCompanyName($req->get('term'))->toArray() as $c) {
//            $tmp[$c['id']] = $c['name'];
//        }

        return $company->getCompanyName($req->get('term'));
    }

    public function deleteManyPerson(Request $req) {
        foreach ($req->get('data') as $id) {
            $this->delete($id);
        }
    }

    public function changePosition(Request $req) {
        if ($this->personModel->changePosition($req->get('position')[1]['value'], $req->get('personsId'))) {
            return $this->flashMessage('message/person.changePositionSuccess');
        }
    }

}
