import { NgClass, NgFor, NgIf } from '@angular/common';
import { HttpClient } from '@angular/common/http';
import { Component, inject } from '@angular/core';
import { FormBuilder, ReactiveFormsModule } from '@angular/forms';
import { environment } from '../../environment/environment';
import { Router } from '@angular/router';
import { AuthenticationModel } from './authentication.model';

@Component({
  selector: 'app-authentication',
  standalone: true,
  imports: [ReactiveFormsModule, NgClass, NgIf, NgFor],
  templateUrl: './authentication.component.html',
  styleUrl: './authentication.component.css'
})
export class AuthenticationComponent {
  private router = inject(Router)
  private httpClient = inject(HttpClient)
  private formBuilder = inject(FormBuilder)

  loginForm = this.formBuilder.group({
    email: '',
    password: ''
  })

  registerForm = this.formBuilder.group({
    name: '',
    email: '',
    password: ''
  })

  loginEmailErrors: string[] | undefined = undefined
  loginPasswordErrors: string[] | undefined = undefined
  registerNameErrors: string[] | undefined = undefined
  registerEmailErrors: string[] | undefined = undefined
  registerPasswordErrors: string[] | undefined = undefined

  login() {
    console.log('request started')
    console.log(this.loginForm.value)
    this.httpClient.post<AuthenticationModel>(
      `${environment.apiUrl}/login`,
      this.loginForm.value,
      { withCredentials: true }
    ).subscribe({
      next: user => {
        console.log(user)
        sessionStorage.setItem('userId', user.id.toString())
        sessionStorage.setItem('userName', user.name)
        sessionStorage.setItem('userEmail', user.email)
        sessionStorage.setItem('userRole', user.role)
      },
      error: error => {
        console.log(error.error)
        if (error.error.error !== undefined) {
          this.loginEmailErrors = [error.error.error]
          this.loginPasswordErrors = [error.error.error]
        } else {
          this.loginEmailErrors = error.error.email || []
          this.loginPasswordErrors = error.error.password || []
        }
      },
      complete: () => {
        console.log('request completed')
        this.loginEmailErrors = []
        this.loginPasswordErrors = []
        this.router.navigate(['cars'])
      }
    })
  }

  register() {
    console.log('request started')
    console.log(this.registerForm.value)
    this.httpClient.post<AuthenticationModel>(
      `${environment.apiUrl}/register`,
      this.registerForm.value,
      { withCredentials: true }
    ).subscribe({
      next: user => {
        console.log(user)
        sessionStorage.setItem('userId', user.id.toString())
        sessionStorage.setItem('userName', user.name)
        sessionStorage.setItem('userEmail', user.email)
        sessionStorage.setItem('userRole', user.role)
      },
      error: error => {
        console.log(error.error)
        if (error.error.error !== undefined) {
          this.registerNameErrors = [error.error.error]
          this.registerEmailErrors = [error.error.error]
          this.registerPasswordErrors = [error.error.error]
        } else {
          this.registerNameErrors = error.error.name || []
          this.registerEmailErrors = error.error.email || []
          this.registerPasswordErrors = error.error.password || []
        }
      },
      complete: () => {
        console.log('request completed')
        this.registerNameErrors = []
        this.registerEmailErrors = []
        this.registerPasswordErrors = []
        this.router.navigate(['cars'])
      }
    })
  }
}
