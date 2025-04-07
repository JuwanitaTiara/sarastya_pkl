using System;
using System.Net.Http;
using System.Text;
using System.Text.Json;
using Microsoft.Maui.Controls;

namespace HelloMaui2
{
    public partial class MainPage : ContentPage
    {
        public MainPage()
        {
            InitializeComponent();
        }

        private async void OnRegisterClicked(object sender, EventArgs e)
        {
            var username = UsernameEntry.Text;
            var password = PasswordEntry.Text;

            var client = new HttpClient();

            var json = JsonSerializer.Serialize(new
            {
                username = username,
                password = password
            });

            var content = new StringContent(json, Encoding.UTF8, "application/json");

            try
            {
                var response = await client.PostAsync("http://10.0.2.2/api/test.php", content); // ganti IP sesuai PC kamu
                var result = await response.Content.ReadAsStringAsync();
                await DisplayAlert("Respon dari Server", result, "OK");
            }
            catch (Exception ex)
            {
                await DisplayAlert("Error", ex.Message, "OK");
            }
        }
    }
}
