<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CompanyController
 *
 * @author gabriel
 */

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\CompanyModel as CompanyModel;
use Illuminate\Http\Request as Request;
use \App\Models\CategoryModel as CategoryModel;
use App\Http\Requests\StoreCompanyRequest;
use Illuminate\Support\Facades\DB as DB;

//use App\Models\LanguagesModel as LanguagesModel;
//use Illuminate\Support\Facades\Gate as Gate;
//use Illuminate\Support\Facades\Auth as Auth;


class CompanyController extends Controller {

    private $model;

//    private $categoryModel;

    public function __construct(CompanyModel $company) {
        $this->model = $company;
    }

    /**
     *  Метод, който извиква view изпечатване на всички 
     * @param Request $req
     * @return type
     */
    public function index(Request $req) {
        $this->authorize('company_index', $this->model);


        $data = $this->model->getAllCompany($req);
        $this->appends($req, $data);

        return view("Company.index", ['company' => $data]);
    }

    /**
     * Метод, който извиква view за редактиране на компания
     * @param type $id
     * @param CategoryModel $category
     * @return type
     */
    public function edit($id, CategoryModel $category) {
        $this->authorize('company_edit', $this->model);


        return view('Company.edit', ['company' => $this->model->getCompany($id),
            'category' => $category->getCategory()]);
    }

    /**
     * Метод, който изввиква модела, за да запише промените в базата
     * @param Request $req
     * @param StoreCompanyRequest $company
     * @return type
     */
    public function update(Request $req, StoreCompanyRequest $company) {

        if ($this->model->update($req->all())) {
            $this->flashMessage('message/company.updateSuccess');

            return redirect('company/');
        } else {
            $this->flashMessage('message/company.updateDanger', 'danger');
            return redirect('company/');
        }
    }

    /**
     * 
     * @param type $id
     * @return type
     */
    public function delete($id) {
        $this->authorize('company_delete', $this->model);
        //check model bind
        if ($this->model->deleteCompany($id)) {
            $this->flashMessage('message/company.deleteSuccess');
        } else {
            $this->flashMessage('message/company.deleteDanger', 'danger');
        }
        return redirect("company/");
    }

    /**
     * Метод, който извиква view за добавяне на компания
     * @param CategoryModel $category
     * @return type
     */
    public function companyAdd(CategoryModel $category) {
        return view('Company.newCompany', ['category' => $category->getCategory()]);
    }

    /**
     * Метод, който извиква модела за записване на нова компания в базата
     * @param Request $req
     * @param StoreCompanyRequest $company
     * @return type
     */
    public function save(Request $req, StoreCompanyRequest $company) {
        if ($this->model->saveNewCompany($req->all())) {
            $this->flashMessage('message/company.saveSuccess');
        } else {
            $this->flashMessage('message/company.saveDanger', 'danger');
        }
        return redirect('company/');
    }

    /**
     * Метод, който връща информацията на компанията по id
     * @param type $id
     * @return type
     */
    public function infoCompany($id) {
        return view('Company.infoCompany', ['company' => $this->model->getCompany($id)]);
    }

    public function deleteMenyCompany(Request $req) {
        if ($this->model->deleteMenyCompany($req->all())) {
            $this->flashMessage('message/company.deleteMenyCompanySuccess');
        }
    }

}
