<template>
  <vLoader :loader="loader"></vLoader>
    <h2>{{dictionary.title[language]}}</h2>
    <div class="form">
      <form >
      <table>
        <tr>
          <td>
            <label for="name">{{dictionary.name[language]}}:*</label>
          </td>
          <td>
            <input 
              type="text" 
              id="name" 
              placeholder="Piter Parker"
              maxlength="20" 
              required minlength="4"
              v-model="name" />
          </td>
        </tr>
        <tr>
          <td>
            <label for="nickname">{{dictionary.nickname[language]}}:*</label>
          </td>
          <td>
            <input 
              type="text" 
              id="nickname" 
              placeholder="Spiderman" 
              maxlength="15" 
              required
              v-model="nickname">
          </td>
        </tr>
        <tr>
          <td>
            <label>{{dictionary.gender[language]}}*</label>
          </td>
          <td class="radio">
            <input  type="radio" name="gender" value="M" id="m" v-model="gender">
            <label  for="m">{{dictionary.genderM[language]}}</label>
            <br>
            <input  type="radio" name="gender" value="W" id="w" v-model="gender">
            <label  for="w">{{dictionary.genderW[language]}}</label>
          </td>
        </tr>
        <tr>
          <td>
            <label for="birth">{{dictionary.birth[language]}}:*</label>
          </td>
          <td>
            <input type="date" id="birth" v-model="birth">
          </td>
        </tr>
        <tr>
          <td>
            <label for="country">{{dictionary.country[language]}}:*</label>
          </td>
          <td>
            <select id="country" required v-model="country">
        <option value="  " selected>Select a country</option>
        <option value="--">Not Specified</option>
        <option value="UA">Ukraine</option>
        <option value="GE">Georgia</option>
        <option value="AF">Afghanistan</option>
        <option value="AL">Albania</option>
        <option value="DZ">Algeria</option>
        <option value="AS">American Samoa</option>
        <option value="AD">Andorra</option>
        <option value="AO">Angola</option>
        <option value="AI">Anguilla</option>
        <option value="AQ">Antarctica</option>
        <option value="AG">Antigua and Barbuda</option>
        <option value="AR">Argentina</option>
        <option value="AM">Armenia</option>
        <option value="AW">Aruba</option>
        <option value="AU">Australia</option>
        <option value="AT">Austria</option>
        <option value="AZ">Azerbaijan</option>
        <option value="BS">Bahamas</option>
        <option value="BH">Bahrain</option>
        <option value="BD">Bangladesh</option>
        <option value="BB">Barbados</option>
        <option value="BY">Belarus</option>
        <option value="BE">Belgium</option>
        <option value="BZ">Belize</option>
        <option value="BJ">Benin</option>
        <option value="BM">Bermuda</option>
        <option value="BT">Bhutan</option>
        <option value="BO">Bolivia</option>
        <option value="BA">Bosnia and Herzegowina</option>
        <option value="BW">Botswana</option>
        <option value="BV">Bouvet Island</option>
        <option value="BR">Brazil</option>
        <option value="IO">British Indian Ocean Territory</option>
        <option value="BN">Brunei Darussalam</option>
        <option value="BG">Bulgaria</option>
        <option value="BF">Burkina Faso</option>
        <option value="BI">Burundi</option>
        <option value="KH">Cambodia</option>
        <option value="CM">Cameroon</option>
        <option value="CA">Canada</option>
        <option value="CV">Cape Verde</option>
        <option value="KY">Cayman Islands</option>
        <option value="CF">Central African Republic</option>
        <option value="TD">Chad</option>
        <option value="CL">Chile</option>
        <option value="CN">China</option>
        <option value="CX">Christmas Island</option>
        <option value="CC">Cocos (Keeling) Islands</option>
        <option value="CO">Colombia</option>
        <option value="KM">Comoros</option>
        <option value="CG">Congo</option>
        <option value="CD">Congo, the Democratic Republic of the</option>
        <option value="CK">Cook Islands</option>
        <option value="CR">Costa Rica</option>
        <option value="CI">Cote d'Ivoire</option>
        <option value="HR">Croatia (Hrvatska)</option>
        <option value="CU">Cuba</option>
        <option value="CY">Cyprus</option>
        <option value="CZ">Czech Republic</option>
        <option value="DK">Denmark</option>
        <option value="DJ">Djibouti</option>
        <option value="DM">Dominica</option>
        <option value="DO">Dominican Republic</option>
        <option value="TP">East Timor</option>
        <option value="EC">Ecuador</option>
        <option value="EG">Egypt</option>
        <option value="SV">El Salvador</option>
        <option value="GQ">Equatorial Guinea</option>
        <option value="ER">Eritrea</option>
        <option value="EE">Estonia</option>
        <option value="ET">Ethiopia</option>
        <option value="FK">Falkland Islands (Malvinas)</option>
        <option value="FO">Faroe Islands</option>
        <option value="FJ">Fiji</option>
        <option value="FI">Finland</option>
        <option value="FR">France</option>
        <option value="FX">France, Metropolitan</option>
        <option value="GF">French Guiana</option>
        <option value="PF">French Polynesia</option>
        <option value="TF">French Southern Territories</option>
        <option value="GA">Gabon</option>
        <option value="GM">Gambia</option>
        <option value="GE">Georgia</option>
        <option value="DE">Germany</option>
        <option value="GH">Ghana</option>
        <option value="GI">Gibraltar</option>
        <option value="GR">Greece</option>
        <option value="GL">Greenland</option>
        <option value="GD">Grenada</option>
        <option value="GP">Guadeloupe</option>
        <option value="GU">Guam</option>
        <option value="GT">Guatemala</option>
        <option value="GN">Guinea</option>
        <option value="GW">Guinea-Bissau</option>
        <option value="GY">Guyana</option>
        <option value="HT">Haiti</option>
        <option value="HM">Heard and Mc Donald Islands</option>
        <option value="VA">Holy See (Vatican City State)</option>
        <option value="HN">Honduras</option>
        <option value="HK">Hong Kong</option>
        <option value="HU">Hungary</option>
        <option value="IS">Iceland</option>
        <option value="IN">India</option>
        <option value="ID">Indonesia</option>
        <option value="IR">Iran (Islamic Republic of)</option>
        <option value="IQ">Iraq</option>
        <option value="IE">Ireland</option>
        <option value="IL">Israel</option>
        <option value="IT">Italy</option>
        <option value="JM">Jamaica</option>
        <option value="JP">Japan</option>
        <option value="JO">Jordan</option>
        <option value="KZ">Kazakhstan</option>
        <option value="KE">Kenya</option>
        <option value="KI">Kiribati</option>
        <option value="KP">Korea, Democratic People's Republic of</option>
        <option value="KR">Korea, Republic of</option>
        <option value="KW">Kuwait</option>
        <option value="KG">Kyrgyzstan</option>
        <option value="LA">Lao People's Democratic Republic</option>
        <option value="LV">Latvia</option>
        <option value="LB">Lebanon</option>
        <option value="LS">Lesotho</option>
        <option value="LR">Liberia</option>
        <option value="LY">Libyan Arab Jamahiriya</option>
        <option value="LI">Liechtenstein</option>
        <option value="LT">Lithuania</option>
        <option value="LU">Luxembourg</option>
        <option value="MO">Macau</option>
        <option value="MK">Macedonia, The Former Yugoslav Republic of</option>
        <option value="MG">Madagascar</option>
        <option value="MW">Malawi</option>
        <option value="MY">Malaysia</option>
        <option value="MV">Maldives</option>
        <option value="ML">Mali</option>
        <option value="MT">Malta</option>
        <option value="MH">Marshall Islands</option>
        <option value="MQ">Martinique</option>
        <option value="MR">Mauritania</option>
        <option value="MU">Mauritius</option>
        <option value="YT">Mayotte</option>
        <option value="MX">Mexico</option>
        <option value="FM">Micronesia, Federated States of</option>
        <option value="MD">Moldova, Republic of</option>
        <option value="MC">Monaco</option>
        <option value="MN">Mongolia</option>
        <option value="MS">Montserrat</option>
        <option value="MA">Morocco</option>
        <option value="MZ">Mozambique</option>
        <option value="MM">Myanmar</option>
        <option value="NA">Namibia</option>
        <option value="NR">Nauru</option>
        <option value="NP">Nepal</option>
        <option value="NL">Netherlands</option>
        <option value="AN">Netherlands Antilles</option>
        <option value="NC">New Caledonia</option>
        <option value="NZ">New Zealand</option>
        <option value="NI">Nicaragua</option>
        <option value="NE">Niger</option>
        <option value="NG">Nigeria</option>
        <option value="NU">Niue</option>
        <option value="NF">Norfolk Island</option>
        <option value="MP">Northern Mariana Islands</option>
        <option value="NO">Norway</option>
        <option value="OM">Oman</option>
        <option value="PK">Pakistan</option>
        <option value="PW">Palau</option>
        <option value="PA">Panama</option>
        <option value="PG">Papua New Guinea</option>
        <option value="PY">Paraguay</option>
        <option value="PE">Peru</option>
        <option value="PH">Philippines</option>
        <option value="PN">Pitcairn</option>
        <option value="PL">Poland</option>
        <option value="PT">Portugal</option>
        <option value="PR">Puerto Rico</option>
        <option value="QA">Qatar</option>
        <option value="RE">Reunion</option>
        <option value="RO">Romania</option>
        <option value="RU" disabled>russian federation</option>
        <option value="RW">Rwanda</option>
        <option value="KN">Saint Kitts and Nevis</option> 
        <option value="LC">Saint LUCIA</option>
        <option value="VC">Saint Vincent and the Grenadines</option>
        <option value="WS">Samoa</option>
        <option value="SM">San Marino</option>
        <option value="ST">Sao Tome and Principe</option> 
        <option value="SA">Saudi Arabia</option>
        <option value="SN">Senegal</option>
        <option value="SC">Seychelles</option>
        <option value="SL">Sierra Leone</option>
        <option value="SG">Singapore</option>
        <option value="SK">Slovakia (Slovak Republic)</option>
        <option value="SI">Slovenia</option>
        <option value="SB">Solomon Islands</option>
        <option value="SO">Somalia</option>
        <option value="ZA">South Africa</option>
        <option value="GS">South Georgia and the South Sandwich Islands</option>
        <option value="ES">Spain</option>
        <option value="LK">Sri Lanka</option>
        <option value="SH">St. Helena</option>
        <option value="PM">St. Pierre and Miquelon</option>
        <option value="SD">Sudan</option>
        <option value="SR">Suriname</option>
        <option value="SJ">Svalbard and Jan Mayen Islands</option>
        <option value="SZ">Swaziland</option>
        <option value="SE">Sweden</option>
        <option value="CH">Switzerland</option>
        <option value="SY">Syrian Arab Republic</option>
        <option value="TW">Taiwan, Province of China</option>
        <option value="TJ">Tajikistan</option>
        <option value="TZ">Tanzania, United Republic of</option>
        <option value="TH">Thailand</option>
        <option value="TG">Togo</option>
        <option value="TK">Tokelau</option>
        <option value="TO">Tonga</option>
        <option value="TT">Trinidad and Tobago</option>
        <option value="TN">Tunisia</option>
        <option value="TR">Turkey</option>
        <option value="TM">Turkmenistan</option>
        <option value="TC">Turks and Caicos Islands</option>
        <option value="TV">Tuvalu</option>
        <option value="UG">Uganda</option>
        <option value="UA">Ukraine</option>
        <option value="AE">United Arab Emirates</option>
        <option value="GB">United Kingdom</option>
        <option value="US">United States</option>
        <option value="UM">United States Minor Outlying Islands</option>
        <option value="UY">Uruguay</option>
        <option value="UZ">Uzbekistan</option>
        <option value="VU">Vanuatu</option>
        <option value="VE">Venezuela</option>
        <option value="VN">Viet Nam</option>
        <option value="VG">Virgin Islands (British)</option>
        <option value="VI">Virgin Islands (U.S.)</option>
        <option value="WF">Wallis and Futuna Islands</option>
        <option value="EH">Western Sahara</option>
        <option value="YE">Yemen</option>
        <option value="YU">Yugoslavia</option>
        <option value="ZM">Zambia</option>
        <option value="ZW">Zimbabwe</option>
      </select>
          </td>
        </tr>
        <tr>
          <td>
            <label for="course">{{dictionary.course[language]}}*:</label>
          </td>
          <td>
            <select id="course" required v-model="lang">
              <option value="ge" >{{dictionary.courseGE[language]}}</option>
              <option value="ua">{{dictionary.courseUA[language]}}</option>
            </select>
          </td>
        </tr>
        <tr>
          <td>
            <label for="phone">{{dictionary.phone[language]}}</label>
          </td>
          <td>
            <input type="tel" id="phone" maxlength="16" placeholder="911" v-model="phone">
          </td>
        </tr>
        <tr>
          <td>
            <label for="about_yourself">{{dictionary.aboutYourself[language]}}:</label>
          </td>
          <td>
            <textarea id="about_yourself" cols="20" rows="5" placeholder="your hobby, credo, lifestyle...." maxlength="100" v-model="about_yourself"></textarea>
          </td>
        </tr>
      </table>
      <input class="button" type="submit" :value="dictionary.submit[language]" @click.prevent="saveUserInfo" >
      
    </form>
    </div>
    
</template>

<script>
import dictionary from './dictionary/inputUserInfo';
  import vLoader from "./vLoader.vue"
export default {
  name: 'vInputUserInfo',
    components: {
        vLoader
    },
  emits: ['canGoStudy'],
  props: {
    userInfo: Object,
    language: String
  },
  data() {
      return {
        loader: false,
        dictionary,
        newInfo: this.userInfo,
        name: this.userInfo.name,
        nickname: this.userInfo.nickname,
        gender: this.userInfo.gender,
        birth: this.userInfo.birth,
        country: this.userInfo.country,
        lang: this.userInfo.lang,
        phone: this.userInfo.phone,
        about_yourself: this.userInfo.about_yourself
      }
  },
  methods: {
    getCookies(cname) {
        //зччитування JWT ключа для перевірки валідації токена
        let name = cname + "=";
        let decodedCookie = decodeURIComponent(document.cookie);
        let ca = decodedCookie.split(";");
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == " ") {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
      },

    saveUserInfo() {
      let userNewInfo = {
        email: this.userInfo.email,
        name: this.name,
        nickname: this.nickname,
        gender: this.gender,
        birth: this.birth,
        country: this.country,
        lang: this.lang,
        phone: this.phone,
        about_yourself: this.about_yourself,
        id: this.userInfo.id,
        icon: this.userInfo.icon,
        jwt: undefined
      }
      this.newInfo = userNewInfo
      this.updateUserInfo()
    },
    async updateUserInfo() {
      this.loader = true
      this.newInfo.jwt = this.getCookies('jwt')
      console.log(JSON.stringify( this.newInfo))
      const url = 'http://ukrgeserver/api/update_user.php'
      const json = JSON.stringify(this.newInfo)
      
      try {
          let response = await fetch(url, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Access-Control-Allow-Origin': '*' 
            },
            body: json
          });
          let result = await response.json()
          console.log(result.userInfo.nickname)
          this.$emit('canGoStudy', result.userInfo.nickname)
          const person = JSON.stringify(result.userInfo)
          this.setCookies('userInfo', person, 1)
          alert('Success updated')
      } catch (error) {
          console.log(error)
      } finally {
        this.loader = false
      }
            
      },
    setCookies(cname, cvalue, exdays) {
            const d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            const expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
            this.isUserLoggined = cvalue
      },
  },
  mounted() {
  }
        
  
}
</script>

<style scoped>

h2 {
  display: block;
  text-shadow: 1px 1px 2px rgb(159, 159, 159), 0 0 1em rgb(0, 0, 0), 0 0 0.5em rgb(0, 0, 0);
  color: #fff;
  width: fit-content;
  margin: auto;
  margin-bottom: 20px0;
}


.form {
  width: fit-content;
  margin: auto;
  align-items: center;
  font-size: larger;
  color: #FFF;
  background: #2d2d2d;
  border: 5px solid rgb(13, 154, 55);
  border-radius: 10px;
}

table {
  align-items: center;
}

input, textarea, select {
  border: 0px solid red;
  width: 100%;
  font-size: large;
  background: #1d1d1d;
  color: #fff;
  box-shadow: none;
  border-radius: 10px;
  border: 2px solid black;
}

td{
  align-self: flex-end;
  margin: 10px;
  padding: 10px;
}

.button {
  display: block;
  margin: auto;
  color: #fff;
  padding: 10px;
  font-size: larger;
  width: 50%;
}

textarea { 
  resize: none; 
}

label {
  display: block;
  text-align: right;
  /*border: 1px solid red;*/
  margin-right: 0px;

}

.radio {
  display: flex;
}
input[type="radio"] {
  border: 4px solid red;
  opacity: 10%;
  position: relative;
}

.radio label,
.radio input {
  display: inline;
  margin: 0;
  padding: 0;
  justify-content: center;
  align-content: center;

}

</style>