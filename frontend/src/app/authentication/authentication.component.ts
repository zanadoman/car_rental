import { HttpClient } from '@angular/common/http';
import { Component, inject } from '@angular/core';
import { FormBuilder, ReactiveFormsModule } from '@angular/forms';

@Component({
  selector: 'app-authentication',
  standalone: true,
  imports: [ReactiveFormsModule],
  templateUrl: './authentication.component.html',
  styleUrl: './authentication.component.css'
})
export class AuthenticationComponent {
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

  login() {
    console.log(this.loginForm.value)
    this.httpClient.post('http://127.0.0.1:8000/login', this.loginForm.value)
      .subscribe({
        next: (value) => console.log(value),
        error: (error) => console.log(error),
        complete: () => console.log('completed')
      })
  }

  register() {
    console.log(this.registerForm.value)
    this.httpClient.post('http://127.0.0.1:8000/register', this.registerForm.value)
      .subscribe({
        next: (value) => console.log(value),
        error: (error) => console.log(error),
        complete: () => console.log('completed')
      })
  }
}
