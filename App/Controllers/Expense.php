<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Expenses;
use \App\Auth;
use \App\Dates;
use \App\Flash;

/**
 * Login controller
 *
 * PHP version 7.0
 */
class Expense extends Authenticated
{

    /**
     * Show the login page
     *
     * @return void
     */
    public function newAction()
    {	
        View::renderTemplate('Expense/index.html', [
		'todaysDate' => Dates::getTodaysDate(),
		'userExpenses' => Expenses::getUserExpenseCategories(),
		'paymentMethods' => Expenses::getUserPaymentMethods(),
		'lastDate' => Dates::getLastDayOfNextMonth()
		]);
    }

    /**
     * Log in a user
     *
     * @return void
     */
    public function createAction()
    {
		if(isset($_POST['amount'])) {
			$expense = new Expenses($_POST);

			if ($expense->save()) {

				Flash::addMessage('Sukces! Wydatek został dodany.');

				$this->redirect('/expense/new');

			} else {
					
				View::renderTemplate('Expense/index.html', [
					'expense' => $expense,
					'todaysDate' => Dates::getTodaysDate(),
					'userExpenses' => Expenses::getUserExpenseCategories(),
					'paymentMethods' => Expenses::getUserPaymentMethods(),
					'lastDate' => Dates::getLastDayOfNextMonth()
				]);
				
			} 	
		} else {
			$this->redirect('/expense/new');
		}
    }
	
	public function  checkLimitAction()
	{
		 if(isset($_POST["expenseCategory"]))  
		 {  $expense = new Expenses($_POST);
			$expense->showExpenseLimit();
		 } else {
			$this->redirect('/expense/new');
		 }			 
	}	
	
	public function  getFinalValueAction()
	{
		 if(isset($_POST["amount"]))  
		 { 	
			$expense = new Expenses($_POST);
			$value = $expense->getFinalValue();
		 } else {
			$this->redirect('/expense/new');
		 }
	}

}
