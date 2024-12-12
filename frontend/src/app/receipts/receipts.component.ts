import { HttpClient } from '@angular/common/http';
import { Component, inject } from '@angular/core';
import { Router } from '@angular/router';
import { Receipts } from './receipts.model';
import { environment } from '../../environment/environment';
import { DatePipe, NgFor, NgIf } from '@angular/common';
import { FormBuilder, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { Rent } from '../rents/rent.model';
import { Car } from '../cars/car.model';

@Component({
  selector: 'app-receipts',
  standalone: true,
  imports: [ReactiveFormsModule, DatePipe, NgIf, NgFor],
  templateUrl: './receipts.component.html',
  styleUrl: './receipts.component.css'
})
export class ReceiptsComponent {
  private router = inject(Router)
  private httpClient = inject(HttpClient)
  private formBuilder = inject(FormBuilder)

  userRole = 'visitor'
  currentDate = new Date

  registerReceiptForm = this.formBuilder.group({
    rent_id: '',
    kilometers: '',
  })

  receipts: Receipts[] = []
  selectedCategory = 'all'
  sortedField = ''
  filteredCategories: string[] = []
  filteredReceipts: Receipts[] = []
  filteredForms = new Map<number, FormGroup>

  constructor() {
    this.userRole = sessionStorage.getItem('userRole') || 'visitor'
    if (!['customer', 'salesman', 'admin'].includes(this.userRole)) {
      this.router.navigate([''])
    }
  }

  ngOnInit() {
    this.getReceipts()
  }

  getReceipts() {
    console.log('request started')
    this.httpClient.get<Receipts[]>(
      `${environment.apiUrl}/receipts`,
      { withCredentials: true }
    ).subscribe({
      next: receipt => {
        console.log(receipt)
        this.receipts = receipt
      },
      error: error => console.log(error.error),
      complete: () => {
        this.filterForms()
        console.log('request completed')
      }
    })
  }

  registerReceipt() {
    console.log('request started')
    console.log(this.registerReceiptForm.value)

    if (!this.registerReceiptForm.value.rent_id || !this.registerReceiptForm.value.kilometers) {
      console.error('Form is invalid');
      window.alert('Please fill out all fields.');
      return;
    }

    this.httpClient.get<Rent>(
      `${environment.apiUrl}/rent/${this.registerReceiptForm.value.rent_id}`,
      { withCredentials: true }
    ).subscribe({
      next: response => {
        console.log(response)
        this.registerReceipt2(response)
      }, error: error => {
        console.log(error.error)
      },
    })
  }

  registerReceipt2(rent: Rent) {
    this.httpClient.get<Car>(
      `${environment.apiUrl}/car/${rent.car_id}`,
      { withCredentials: true }
    ).subscribe({
      next: response => {
        console.log(response)
        this.registerReceipt3(rent, response)
      }, error: error => {
        console.log(error.error)
      },
    })
  }

  registerReceipt3(rent: Rent, car: Car) {
    let beginDate = new Date(rent.begin);
    let endDate = new Date(rent.end);
    let returnDate = new Date(rent.return);

    let days = Math.floor((endDate.getTime() - beginDate.getTime()) / (1000 * 60 * 60 * 24));
    let delay = Math.floor((returnDate.getTime() - endDate.getTime()) / (1000 * 60 * 60 * 24));

    this.httpClient.post(
      `${environment.apiUrl}/receipts`,
      {
        user_id: rent.user_id,
        car_id: rent.car_id,
        kilometers: this.registerReceiptForm.value.kilometers,
        begin: rent.begin,
        end: rent.end,
        delay: delay,
        totalfee: (days + (delay)) * car.dailyfee,
      },
      { withCredentials: true }
    ).subscribe({
      next: response => console.log(response),
      error: error => {
        console.log(error.error)
        if (rent.return === null && this.registerReceiptForm.value.kilometers !== '') {
          window.alert('The car has not been returned yet.');
        }
      },
      complete: () => {
        console.log('request completed')
        this.getReceipts()
      }
    })
  }

  updateReceipt(id: number) {
    console.log('request started')
    console.log(id)
    console.log(this.filteredForms.get(id)?.value)
    this.httpClient.put(
      `${environment.apiUrl}/receipt/${id}`,
      this.filteredForms.get(id)?.value,
      { withCredentials: true }
    ).subscribe({
      next: response => console.log(response),
      error: error => console.log(error.error),
      complete: () => {
        console.log('request completed')
        this.getReceipts()
      }
    })
  }

  deleteReceipt(id: number) {
    console.log('request started')
    console.log(id)
    this.httpClient.delete(
      `${environment.apiUrl}/receipt/${id}`,
      { withCredentials: true }
    ).subscribe({
      next: response => console.log(response),
      error: error => console.log(error.error),
      complete: () => {
        console.log('request completed')
        this.getReceipts()
      }
    })
  }

  filterForms() {
    this.filteredForms = new Map(this.receipts.map(receipt => {
      return [
        receipt.id,
        this.formBuilder.group({
          user_id: receipt.user_id,
          car_id: receipt.car_id,
          kilometers: receipt.kilometers,
          begin: receipt.begin,
          end: receipt.end,
          delay: receipt.delay,
          totalfee: receipt.totalfee
        })
      ]
    }))
    console.log('forms filtered')
    console.log(this.filteredForms)
  }
}
