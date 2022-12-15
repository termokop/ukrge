let func = {
    translit(str) {
        let ge = ['ა','ბ','გ','დ','ე','ვ','ზ','თ','ი','კ','ლ','მ','ნ','ო','პ','ჟ','რ','ს','ტ','უ','ფ','ქ','ღ','ყ','შ','ჩ','ც','ძ','წ','ჭ','ხ','ჯ','ჰ']
        let ua = ['а','б','ґ','д','е','в','з','т*','і','к','л','м','н','о','п','ж','р','с','т','у','ф*','к*','р*','к','ш','ч','ц','дз','ц*','ч*','х','дж','г']



        if(!ge.includes(str[0])) return str

        // записую трансліт в змінну res
        let spaces = 0
        for( let i = 0; i<str.length; i++) {
            if(str[i] === ' ') spaces++
        }
        // записую трансліт в змінну res
        let res = []
        for (let i = 0; i < str.length; i++) {
                res.push(~ge.indexOf(str[i]) ? ua[ge.indexOf(str[i])] : str[i])
            
        }
        let result = '';
        // додаємо значення в таблиці, розділені пробілами
        let j = 0;
        for(let i = 0; i<= spaces; i++) {
            let strForTableGE = ``
            let strForTableUA = ``
            while(j<str.length) {
                if(str[j] === ' ') {
                    j++
                    break;}

                strForTableGE += `<td>${str[j]}</td>`
                strForTableUA += `<td>${res[j]}</td>`
                j++
            }
            result += `
            <table>
                <tr class="ge">
                    ${strForTableGE}
                </tr>
                <tr class="ua"  style="color:gray; font-size:12px">
                    ${strForTableUA}
                </tr>
            </table>
            &nbsp;&nbsp;&nbsp;`
        }
        return result
    },
    shuffle(arr) {
        let numbers = arr;
        let first,
            second,
            temp,
            count = numbers.length;
        for (let i = 0; i < 4; i++) {
            first = Math.floor(Math.random() * count);
            second = Math.floor(Math.random() * count);
            temp = numbers[first];
            numbers[first] = numbers[second];
            numbers[second] = temp;
        }
        return numbers;
    },
}

export default func